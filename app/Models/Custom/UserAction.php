<?php

namespace App\Models\Custom;

class UserAction
{
    private string $id_user;
    private string $source_label;
    // TODO change to datetime
    private string $date;

    // TODO change date type
    public function __construct(
        string $id_user,
        string $source_label,
        string $date
    )
    {
        $this->id_user = $id_user;
        $this->source_label = $source_label;
        $this->date = $date;
    }

    public static function makeFromArray(array $values): UserAction
    {
        return new static(
            $values['id_user'],
            $values['source_label'],
            $values['date'],
        );
    }

    public function __serialize(): array
    {
        return [
            'id_user' => $this->id_user,
            'source_label' => $this->source_label,
            'date' => $this->date,
        ];
    }
}
