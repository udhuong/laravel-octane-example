<?php

namespace Core\Domain\Entities;

use Carbon\Carbon;

class User
{
    public ?int $id = null;
    public string $name;
    public string $email;
    public string $password;
    public string $token;
    public ?Carbon $created;
}
