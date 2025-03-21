<?php

namespace Core\Presentation\Http\Requests;

use Udhuong\LaravelCommon\Presentation\Http\Requests\ApiRequest;

class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];
    }
}
