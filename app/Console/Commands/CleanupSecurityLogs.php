<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\LoginAttempt;
use App\models\SuspiciousActivity;

class CleanupSecurityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:cleanup {--days=30}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Clean up old login attempts and suspicious activity logs (default: older than 30 days)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = now()->subDays($days);

        // Delete old login attempts
        $deletedAttempts = LoginAttempt::where('attempted_at', '<', $cutoffDate)->delete();
        $this->info("Deleted {$deletedAttempts} old login attempt records");

        // Delete old suspicious activities (keep recent ones for analysis)
        $deletedActivities = SuspiciousActivity::where('created_at', '<', $cutoffDate)->delete();
        $this->info("Deleted {$deletedActivities} old suspicious activity records");

        // Reset login attempts for unlocked accounts
        $resetCount = \App\User::where('locked_until', '<', now())
            ->update([
                'login_attempts' => 0,
                'locked_until' => null
            ]);
        $this->info("Reset login attempts for {$resetCount} expired locked accounts");

        return 0;
    }
}
