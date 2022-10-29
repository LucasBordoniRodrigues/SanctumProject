<?php

namespace App\Lib\Data\OAuth;


interface OAuthClient 
{
    public function authenticate(string $email, string $secret): array;
}