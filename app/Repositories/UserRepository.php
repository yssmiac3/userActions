<?php

namespace App\Repositories;

use App\Models\Custom\DTO\CreateUserDTO;
use App\Models\Custom\User;

interface UserRepository
{
    public function save(CreateUserDTO $dto): User;
    public function fetch(array $searchFields): User;
    public function exists(string $field, string $value);
    public function checkCredentials(string $identifierField, string $password): User;
}
