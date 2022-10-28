<?php

namespace App\Lib\Domain\Entities;

class AccountEntity {

    public string $name;
    public string $token;

    public function __construct(string $name, string $token)
    {
        $this->name = $name;
        $this->token = $token;
    }
}