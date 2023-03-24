<?php

namespace Module5Project\Middleware;

use Tuupola\Middleware\JwtAuthentication;

class JwtGenerator
{
    public static function generateToken(): JwtAuthentication
    {
        return new JwtAuthentication([
            'secret' => $_ENV['JWT_TOKEN']
        ]);
    }
}
