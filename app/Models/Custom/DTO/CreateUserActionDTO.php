<?php

namespace App\Models\Custom\DTO;

class CreateUserActionDTO
{
    private string $id_user;
    private string $source_label;

    /**
     * @return string
     */
    public function getIdUser(): string
    {
        return $this->id_user;
    }

    /**
     * @param string $id_user
     */
    public function setIdUser(string $id_user): void
    {
        $this->id_user = $id_user;
    }

    /**
     * @return string
     */
    public function getSourceLabel(): string
    {
        return $this->source_label;
    }

    /**
     * @param string $source_label
     */
    public function setSourceLabel(string $source_label): void
    {
        $this->source_label = $source_label;
    }

    public function get(): array
    {
        return [
            'id_user' => $this->id_user,
            'source_label' => $this->source_label,
        ];
    }
}
