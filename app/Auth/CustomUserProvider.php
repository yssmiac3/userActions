<?php

namespace App\Auth;

use App\Repositories\UserJsonRepository;
use App\Services\User\UserAuthenticateService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Redis;

class CustomUserProvider implements UserProvider
{
    private UserJsonRepository $repository;

    public function __construct(UserJsonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function retrieveById($identifier)
    {
        return $this->repository->fetch(
            [
                'nickname' => $identifier
            ]
        );
    }

    public function retrieveByToken($identifier, $token)
    {
        $user = $this->repository->fetch([
            'nickname' => $identifier
        ]);
        if (Redis::get($identifier . '_token') == $token)
            return $user;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        Redis::set($user->getAuthIdentifier() . '_token', $token);
    }

    public function retrieveByCredentials(array $credentials)
    {
        if ($this->repository->checkCredentials($credentials['nickname'], $credentials['password']))
            return $this->repository->fetch($credentials);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->repository->checkCredentials($credentials[$user->getAuthIdentifierName()], $credentials[$user->getAuthPassword()]);
    }
}
