<?php

namespace App\Lib\Data\OAuth;


abstract class OAuthClient 
{
    abstract public function authenticate(string $email, string $secret);
}