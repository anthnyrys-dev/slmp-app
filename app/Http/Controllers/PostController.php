<?php

namespace App\Http\Controllers;

use App\Data\StorePostData;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private PostService $postService,
    ) { }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(
            PostResource::collection($this->postService->list()),
            'Posts listed.'
        );
    }

    /**
     * @param StorePostRequest $request
     * @return JsonResponse
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $createdPost = $this->postService->create(StorePostData::fromRequest($request));

        return $this->success(
            new PostResource($createdPost),
            'Post created.',
            Response::HTTP_CREATED
        );
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post): JsonResponse
    {
        return $this->success(new PostResource($post), 'Post retrieved.');
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return $this->noResponse(message: 'Post deleted.');
    }
}
