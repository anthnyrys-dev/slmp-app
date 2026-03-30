<?php

namespace App\Services;

use App\Data\StoreUserData;
use App\Models\User;
use App\Services\UserServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * @return Collection|LengthAwarePaginator
     */
    public function list()
    {
        $userQuery = User::query();

        return request()->filled('per_page')
            ? $userQuery->paginate(request()->input('per_page', 25))
            : $userQuery->get();
    }

    public function create(StoreUserData $storeUserData): User
    {
        return User::create((array) $storeUserData);
    }
}
