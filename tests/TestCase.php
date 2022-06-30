<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function generateAuthenticateUser(array $data = [])
    {
        $user = new User($data);
        $token = $user->createToken('API Token')->accessToken;;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
