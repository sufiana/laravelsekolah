<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SuspiciousLoginAttempt
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $usernameOrEmail;
    public $ipAddress;
    public $attemptNumber;
    public $maxAttempts;

    /**
     * Create a new event instance.
     */
    public function __construct($usernameOrEmail, $ipAddress, $attemptNumber, $maxAttempts)
    {
        $this->usernameOrEmail = $usernameOrEmail;
        $this->ipAddress = $ipAddress;
        $this->attemptNumber = $attemptNumber;
        $this->maxAttempts = $maxAttempts;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('security-monitoring'),
        ];
    }
}
