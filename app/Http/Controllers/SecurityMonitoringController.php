<?php

namespace App\Http\Controllers;

use App\models\LoginAttempt;
use App\models\SuspiciousActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityMonitoringController extends Controller
{
    /**
     * Show suspicious activities dashboard
     */
    public function index()
    {
        // Check if user is admin or has permission
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $suspiciousActivities = SuspiciousActivity::latest('created_at')
            ->paginate(50);

        $recentFailedLogins = LoginAttempt::where('successful', false)
            ->latest('attempted_at')
            ->limit(100)
            ->get()
            ->groupBy('ip_address');

        $lockedAccounts = \App\models\User::where('locked_until', '>', now())
            ->get();

        // Cast locked_until to Carbon instance
        $lockedAccounts = $lockedAccounts->map(function ($account) {
            $account->locked_until = \Carbon\Carbon::parse($account->locked_until);
            return $account;
        });

        $stats = [
            'total_suspicious_activities' => SuspiciousActivity::count(),
            'activities_today' => SuspiciousActivity::whereDate('created_at', today())->count(),
            'locked_accounts' => $lockedAccounts->count(),
            'failed_attempts_today' => LoginAttempt::where('successful', false)
                ->whereDate('attempted_at', today())
                ->count(),
        ];

        return view('admin.security-monitoring', compact(
            'suspiciousActivities',
            'recentFailedLogins',
            'lockedAccounts',
            'stats'
        ));
    }

    /**
     * Get login attempts by user
     */
    public function getUserAttempts(Request $request)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $username = $request->input('username');

        if (!$username) {
            return response()->json(['error' => 'Username required'], 400);
        }

        $attempts = LoginAttempt::where('username_or_email', 'LIKE', "%{$username}%")
            ->latest('attempted_at')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attempts
        ]);
    }

    /**
     * Get IP address statistics
     */
    public function getIpStatistics(Request $request)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $ipAddress = $request->input('ip_address');

        if (!$ipAddress) {
            return response()->json(['error' => 'IP address required'], 400);
        }

        $failedAttempts = LoginAttempt::where('ip_address', $ipAddress)
            ->where('successful', false)
            ->latest('attempted_at')
            ->limit(50)
            ->get();

        $suspiciousActivities = SuspiciousActivity::where('ip_address', $ipAddress)
            ->latest('created_at')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'failed_attempts' => $failedAttempts,
            'suspicious_activities' => $suspiciousActivities
        ]);
    }

    /**
     * Unlock user account (admin only)
     */
    public function unlockAccount(Request $request)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = $request->input('user_id');

        $user = \App\User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->update([
            'locked_until' => null,
            'login_attempts' => 0
        ]);

        SuspiciousActivity::logActivity(
            'account_unlocked_by_admin',
            $user->email,
            '',
            ['admin_id' => Auth::id()],
            $user->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dibuka kunci'
        ]);
    }

    /**
     * Block IP address (admin only)
     */
    public function blockIpAddress(Request $request)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $ipAddress = $request->input('ip_address');

        // Store in cache or database
        cache()->put('blocked_ip_' . $ipAddress, true, now()->addDays(7));

        SuspiciousActivity::create([
            'username_or_email' => 'SYSTEM',
            'ip_address' => $ipAddress,
            'activity_type' => 'ip_blocked_by_admin',
            'details' => json_encode(['admin_id' => Auth::id()]),
            'created_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'IP address berhasil diblokir selama 7 hari'
        ]);
    }

    /**
     * Export suspicious activities
     */
    public function export(Request $request)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $activities = SuspiciousActivity::whereBetween('created_at', [
            now()->subDays(30),
            now()
        ])
            ->latest('created_at')
            ->get();

        $csv = "ID,User,Username,IP Address,Activity Type,Details,Alert Sent,Date\n";

        foreach ($activities as $activity) {
            $csv .= "{$activity->id},";
            $csv .= "{$activity->user_id},";
            $csv .= "\"{$activity->username_or_email}\",";
            $csv .= "{$activity->ip_address},";
            $csv .= "{$activity->activity_type},";
            $csv .= "\"" . str_replace('"', '""', $activity->details) . "\",";
            $csv .= ($activity->alert_sent ? 'Yes' : 'No') . ",";
            $csv .= $activity->created_at->format('Y-m-d H:i:s') . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="suspicious-activities-' . now()->format('Y-m-d') . '.csv"');
    }

    /**
     * Check if user is admin
     */
    protected function isAdmin($user)
    {
        // Only roles 1, 4, 5, 6, 7 can access security monitoring CRUD
        $allowedRoles = [1, 4, 5, 6, 7];
        return in_array($user->role, $allowedRoles);
    }
}
