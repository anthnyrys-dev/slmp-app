<?php

namespace App\Http\Controllers;

use App\Data\StoreUserData;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private UserService $userService,
    ) { }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(
            UserResource::collection($this->userService->list()),
            'Users listed.'
        );
    }

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $createdUser = $this->userService->create(StoreUserData::fromRequest($request));

        return $this->success(
            new UserResource($createdUser),
            'User created.',
            Response::HTTP_CREATED
        );
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->success(new UserResource($user), 'User retrieved.');
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->noResponse(message: 'User deleted.');
    }
}
