<?php

namespace App\Helpers;

use Firebase\JWT\JWT;

class ZoomJWT
{
    public static function generateToken()
    {
        $key = config('zoom.api_key');
        $secret = config('zoom.api_secret');

        $token = [
            'iss' => $key,
            'exp' => time() + 60,
        ];

        return JWT::encode($token, $secret);
    }
}
