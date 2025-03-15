<?php

namespace Core\Domain\Factories;

use Core\Domain\Entities\User;

class UserFactory
{
    public static function create(array $data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];

        return $user;
    }
}
