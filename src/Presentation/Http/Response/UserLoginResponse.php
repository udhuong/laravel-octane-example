<?php

namespace Core\Presentation\Http\Response;

use Core\Domain\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static function format(User $user): array
    {
        return [
            'token' => $user->token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created?->format('Y-m-d H:i:s'),
            ]
        ];
    }
}
