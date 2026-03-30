<?php

namespace App\Http\Controllers;

use App\Data\UserLoginData;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param AuthService $authService
     */
    public function __construct(private AuthService $authService)
    { }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->attempt(UserLoginData::fromRequest($request));

            return $this->success(['token' => $token], message: 'Successfully logged in');
        } catch (ValidationException $e) {
            return $this->error(message: 'Invalid credentials', statusCode: 401);
        } catch (Exception $e) {
            return $this->error(message: 'An unexpected error occurred', statusCode: 500);
        }
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        $this->authService->logout();

        return response()->noContent();
    }
}
