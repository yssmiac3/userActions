<?php

namespace App\Events\User;

use App\Models\Custom\DTO\UserActionEventDTO;

interface UserActionEvent
{
    public function __construct(UserActionEventDTO $dto);
}
