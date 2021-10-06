<?php

namespace App\Models\Custom;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class User implements Authenticatable
{
    // TODO change password from string to hash
    private string $id;
    private string $nickname;
    private string $firstName;
    private string $lastName;
    private int $age;
    private string $password;

    public static array $searchFields = [
      'id',
      'nickname',
    ];

    protected function __construct(
        string $id,
        string $nickname,
        string $firstName,
        string $lastName,
        int $age,
        string $password
    )
    {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->password = $password;
    }

    public static function makeFromArray(array $values): User
    {
        return new static(
            $values['id'],
            $values['nickname'],
            $values['firstName'],
            $values['lastName'],
            $values['age'],
            $values['password']
        );
    }

    public function getSearchFields(): array
    {
        return static::$searchFields;
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'nickname' => $this->nickname,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'age' => $this->age,
            'password' => $this->password,
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAuthIdentifierName(): string
    {
        return 'nickname';
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): string
    {
        return Redis::get($this->nickname . '_token');
    }

    public function setRememberToken($value)
    {
        Redis::set($this->nickname . '_token', Str::random(30));
    }

    public function getRememberTokenName()
    {
        return 'redis_column';
    }
}
