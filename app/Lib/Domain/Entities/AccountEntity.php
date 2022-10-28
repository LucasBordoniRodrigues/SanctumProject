<?php

namespace App\Lib\Entities;

class AccountEntity {

    public string $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

}