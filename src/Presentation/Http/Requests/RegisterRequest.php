<?php

namespace Core\Presentation\Http\Requests;

use Core\Domain\Entities\User;
use Core\Domain\Factories\UserFactory;

class RegisterRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ];
    }

    public function toUser(): User
    {
        return UserFactory::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }
}
