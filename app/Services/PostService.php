<?php

namespace App\Services;

use App\Data\StorePostData;
use App\Models\Post;
use App\Services\PostServiceInterface;

class PostService implements PostServiceInterface
{
    /**
     * @return Collection|LengthAwarePaginator
     */
    public function list()
    {
        $postQuery = Post::query();

        return request()->filled('per_page')
            ? $postQuery->paginate(request()->input('per_page', 25))
            : $postQuery->get();
    }

    public function create(StorePostData $storePostData): Post
    {
        return Post::create((array) $storePostData);
    }
}
