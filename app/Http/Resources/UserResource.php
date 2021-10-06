<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // TODO I need it at all?
        return [
            'id' => 'id',
            'nickname' => 'id',
            'firstName' => 'id',
            'lastName' => 'id',
            'age' => 'id',
        ];
    }
}
