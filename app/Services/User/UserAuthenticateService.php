<?php

namespace App\Services\User;

use App\Exceptions\User\Repository\UsersNotFoundException;
use App\Models\Custom\DTO\CreateUserDTO;
use App\Models\Custom\DTO\LoginUserDTO;
use App\Repositories\UserJsonRepository;

class UserAuthenticateService
{
    private UserJsonRepository $repository;

    public function __construct(UserJsonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function signUp(array $data)
    {
        $dto = new CreateUserDTO();
        $dto->setNickname($data['nickname']);
        $dto->setFirstName($data['firstName']);
        $dto->setLastName($data['lastName']);
        $dto->setAge($data['age']);
        $dto->setPassword($data['password']);

        return $this->repository->save($dto);
    }

    /**
     * @throws UsersNotFoundException
     * @throws \App\Exceptions\User\Repository\NoSuitableSearchFieldsException
     */
    public function signIn(array $data)
    {
        if( $this->repository->checkCredentials(
            $data['nickname'],
            $data['password']
        )) {
            return $this->repository->fetch([
                'nickname' => $data['nickname']
            ]);
        }
    }
}
