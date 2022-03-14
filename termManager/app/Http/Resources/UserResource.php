<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = $role->name;
        }

        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'status' => $this->status,
            'dateCreated' => $this->date_created,
            'dateUpdated' => $this->date_last_modified,
            'privileges' => $roles,
        ];
    }
}
