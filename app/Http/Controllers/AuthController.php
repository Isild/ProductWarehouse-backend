<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRegisterPostRequest;
use App\Http\Requests\Auth\AuthLoginPostRequest;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRegisterPostRequest $request): Response
    {
        $response = $this->authService->register($request->validated());

        return response([
            'api_token' => $response,
            'code' => 201,
            'message' => 'Created',
        ], 201);
    }

    public function login(AuthLoginPostRequest $request): Response
    {
        try {
            $response = $this->authService->login($request->validated());

        } catch (AuthenticationException $e) {
            return response([
                'code' => 401,
                'message' => 'Unauthorized',
            ], 401);
        }

        return response([
            'api_token' => $response['api_token'],
            'user' => $response['user'],
            'code' => 200,
            'message' => 'OK',
        ], 200);
    }
}
