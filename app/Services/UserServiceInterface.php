<?php

namespace App\Services;

use App\Data\StoreUserData;
use App\Models\User;

interface UserServiceInterface
{
    /**
     * @return Collection|LengthAwarePaginator
     */
    public function list();

    public function create(StoreUserData $storeUserData): User;
}
