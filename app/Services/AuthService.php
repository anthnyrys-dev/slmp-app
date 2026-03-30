<?php

namespace App\Services;

use App\Data\UserLoginData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * @param UserLoginData $userLoginData
     * @return string
     * @throws ValidationException
     */
    public function attempt(UserLoginData $userLoginData): string
    {
        $user = User::query()->where('email', $userLoginData->email)->first();

        if (!$user || !Hash::check($userLoginData->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($userLoginData->device_name)->plainTextToken;
    }

    public function logout(): void
    {
        /** @var User $user */
        $user = request()->user();

        $user->currentAccessToken()->delete();
    }
}
