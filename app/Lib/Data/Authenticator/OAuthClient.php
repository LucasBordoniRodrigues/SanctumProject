<?php

namespace App\Lib\Data\Authenticator;


abstract class OAuthClient 
{
    abstract public function authenticate(string $email, string $secret);
}