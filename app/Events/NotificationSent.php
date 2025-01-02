<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $unreadCount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($unreadCount)
    {
        $this->unreadCount = $unreadCount;
    }

    /**
     * The name of the channel on which the event is broadcast.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        // Make sure this channel name matches the one used in your JS
        return new Channel('notif-channel');
    }

    /**
     * Data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        // Send the unread notification count as part of the payload
        return ['unreadCount' => $this->unreadCount];
    }
}
