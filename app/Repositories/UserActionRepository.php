<?php

namespace App\Repositories;

use App\Models\Custom\DTO\CreateUserActionDTO;
use App\Models\Custom\UserAction;

interface UserActionRepository
{
    public function save(CreateUserActionDTO $dto): UserAction;
}
