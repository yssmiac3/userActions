<?php

namespace App\Events\User;

use App\Models\Custom\DTO\UserActionEventDTO;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignedUp implements UserActionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private UserActionEventDTO $dto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserActionEventDTO $dto)
    {
        $this->dto = $dto;
    }
}
