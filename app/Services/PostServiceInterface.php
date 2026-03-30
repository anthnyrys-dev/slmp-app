<?php

namespace App\Services;

interface PostServiceInterface
{
    /**
     * @return Collection|LengthAwarePaginator
     */
    public function list();
}
