<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $messageId;
    public $senderId;
    public $receiverId;
    public $senderRole;

    /**
     * Create a new event instance.
     */
    public function __construct($messageId, $senderId, $receiverId, $senderRole)
    {
        $this->messageId = $messageId;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->senderRole = $senderRole;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [];

        // Jika pengirim pesan yang dihapus adalah client, kirim ke channel admins
        if ($this->senderRole === 'client') {
            $channels[] = new PrivateChannel('admins');
        } else {
            // Jika pengirim pesan adalah admin, kirim ke channel client ybs
            $channels[] = new PrivateChannel('chat.' . $this->receiverId);
            // Dan kirim juga ke channel admins agar dashboard admin lain ikut sinkron
            $channels[] = new PrivateChannel('admins');
        }

        return $channels;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'message_id' => $this->messageId,
            'sender_id' => $this->senderId,
            'receiver_id' => $this->receiverId,
        ];
    }
}
