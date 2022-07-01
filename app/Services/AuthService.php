<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;

class AuthService
{
    public function __construct()
    {
        //
    }

    public function register(array $data): string
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('API Token')->accessToken;

        return $token;
    }

    public function login(array $data): array
    {
        if(auth()->attempt($data)) {
            $token = auth()->user()->createToken('API Token')->accessToken;
            $user = auth()->user();

            return [
                'api_token' => $token,
                'user' => $user,
            ];
        } else {
            throw new AuthenticationException();
        }
    }
}
