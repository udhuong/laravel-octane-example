<?php

namespace Core\Infrastructure\Mappers;

use Carbon\Carbon;
use Core\Domain\Entities\User;

class UserMapper
{
    public static function toEntity(array $data): User
    {
        $user = new User();
        $user->id = $data['id'] ??= 0;
        $user->name = $data['name'] ??= '';
        $user->email = $data['email'] ??= '';
        $user->password = $data['password'] ??= '';
        $user->created = $data['created_at'] != null ? Carbon::parse($data['created_at']) : null;

        return $user;
    }
}
