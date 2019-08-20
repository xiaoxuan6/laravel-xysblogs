<?php

namespace App\Events;

use App\Model\Comment;
use App\Model\Discuss;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReplySendMail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comments;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Discuss $comment)
    {
        $this->comments = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
