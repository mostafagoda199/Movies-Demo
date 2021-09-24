<?php

namespace App\Http\Controllers;

use App\Domain\Responder\Interfaces\IApiHttpResponder;
use App\Exceptions\CustomExceptions\ApiValidationException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     * @param IApiHttpResponder $apiResponder
     */
    public function __construct(private IApiHttpResponder $apiResponder)
    {
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function register(UserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->apiResponder->response(message: trans('message.success_created_user'),data:['access_token' => $token],status: 201);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ApiValidationException
     * @auther Mustafa Goda
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->all())) {
            throw new ApiValidationException(message:trans('message.invalid_user'));
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->apiResponder->response(data:['access_token' => $token]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->apiResponder->response(message: trans('message.user_logout'));
    }
}
