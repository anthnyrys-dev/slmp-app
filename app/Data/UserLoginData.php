<?php

namespace App\Data;

use Illuminate\Http\Request;

class UserLoginData
{
    public function __construct(
        public string $email,
        public string $password,
        public string $device_name,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            email: $request->input('email'),
            password: $request->input('password'),
            device_name: $request->input('device_name'),
        );
    }
}
