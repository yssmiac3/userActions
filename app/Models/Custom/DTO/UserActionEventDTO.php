<?php

namespace App\Models\Custom\DTO;

class UserActionEventDTO
{
    private string $id_user;
    private string $source_label;

    /**
     * @param string $id_user
     * @param string $source_label
     */
    public function __construct(string $id_user, string $source_label)
    {
        $this->id_user = $id_user;
        $this->source_label = $source_label;
    }

    /**
     * @return string
     */
    public function getIdUser(): string
    {
        return $this->id_user;
    }

    /**
     * @return string
     */
    public function getSourceLabel(): string
    {
        return $this->source_label;
    }

}
