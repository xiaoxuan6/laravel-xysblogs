<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Events;

use App\Model\{Comment, Discuss};
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\{Channel, InteractsWithSockets, PresenceChannel, PrivateChannel};

class ReplySendMail
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

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
