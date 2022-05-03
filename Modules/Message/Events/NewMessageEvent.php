<?php

namespace Modules\Message\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Modules\Message\Entities\ChatRoom;
use Modules\Message\Entities\Message;
use Modules\Message\Transformers\MessageResource;

class NewMessageEvent implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    public $chatRoom, $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChatRoom $chatRoom, Message $message)
    {
        $this->chatRoom = $chatRoom;
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('chat-channel-' . $this->chatRoom->id);
    }

    public function broadcastAs()
    {
        return 'new-message';
    }

    public function broadcastWith()
    {
        return [
            'message' => new MessageResource($this->message),
        ];
    }
}
