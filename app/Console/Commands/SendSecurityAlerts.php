<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\SuspiciousActivity;
use App\models\LoginAttempt;

class SendSecurityAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:send-alerts';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Send security alerts to admins for suspicious activities';

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
        // Get unsent alerts
        $unssentAlerts = SuspiciousActivity::where('alert_sent', false)
            ->where('created_at', '>=', now()->subHours(1))
            ->get();

        $alertCount = 0;

        foreach ($unssentAlerts as $alert) {
            // Skip low-priority alerts
            if (in_array($alert->activity_type, ['successful_login'])) {
                continue;
            }

            // Send email to admins
            $this->sendAlertEmail($alert);

            // Mark as sent
            $alert->update([
                'alert_sent' => true,
                'alerted_at' => now()
            ]);

            $alertCount++;
        }

        $this->info("Sent {$alertCount} security alerts to admins");

        return 0;
    }

    /**
     * Send alert email
     */
    protected function sendAlertEmail($activity)
    {
        $admins = \App\User::where('role', 1)->get();

        foreach ($admins as $admin) {
            // TODO: Implement email sending
            // \Illuminate\Support\Facades\Mail::send('emails.security-alert', [
            //     'activity' => $activity,
            //     'admin' => $admin
            // ], function ($message) use ($admin) {
            //     $message->to($admin->email);
            //     $message->subject('Security Alert: ' . ucwords($activity->activity_type));
            // });
        }
    }
}
