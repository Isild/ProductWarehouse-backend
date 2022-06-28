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

    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('API Token')->accessToken;

        return $token;
    }

    public function login(array $data)
    {
        if(auth()->attempt($data)) {
            $token = auth()->user()->createToken('API Token')->accessToken;

            return $token;
        } else {
            throw new AuthenticationException();
        }
    }
}
