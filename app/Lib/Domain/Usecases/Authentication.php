<?php

namespace App\Lib\Usecases;

use App\Lib\Entities\{AccountEntity};

interface Authentication 
{
    public function auth(AuthenticationParams $params): AccountEntity;
}

class AuthenticationParams
{
    public string $email;
    public string $secret;

    public function __construct(string $email, string $secret)
    {
        $this->email = $email;
        $this->secret = $secret;
    }
}