<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channelName, $message, $opponentId, $selfId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channelName, $message, $opponentId, $selfId)
    {
        $this->channelName = $channelName;
        $this->message = $message;
        $this->opponentId = $opponentId;
        $this->selfId = $selfId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('Message' . $this->channelName);
    }

    public function broadcastAs()
    {

        return 'message-event';
    }
}
