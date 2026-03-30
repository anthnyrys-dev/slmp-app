<?php

namespace App\Data;

use Illuminate\Http\Request;

class StoreUserData
{
    public function __construct(
        public string $name,
        public string $username,
        public string $email,
        public string $phone,
        public string $website,
        public string $password,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            username: $request->input('username'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            website: $request->input('website'),
            password: $request->input('password'),
        );
    }
}
