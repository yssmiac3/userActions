<?php

namespace App\Models\Custom\DTO;

class LoginUserDTO
{
    private string $nickname;
    private string $password;

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function get():array
    {
        return [
            'nickname' => $this->nickname,
            'password' => $this->password
        ];
    }
}
