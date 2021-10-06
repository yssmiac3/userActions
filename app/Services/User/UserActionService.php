<?php

namespace App\Services\User;

use App\Models\Custom\DTO\CreateUserActionDTO;
use App\Repositories\UserActionJsonRepository;

class UserActionService
{
    private UserActionJsonRepository $repository;

    public function __construct(UserActionJsonRepository $repository)
   {
       $this->repository = $repository;
   }

   // check data type
    public function save(CreateUserActionDTO $dto)
    {
        $this->repository->save($dto);
    }
}
