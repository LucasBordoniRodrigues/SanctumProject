<?php

namespace App\Lib\Data\Models;

use App\Lib\Domain\Entities\AccountEntity;

class OAuthAccountModel {

    public string $name;
    public string $token;

    public function __construct(string $name, string $token)
    {
        $this->name = $name;
        $this->token = $token;
    }

    public function toEntity(): AccountEntity
    {
        return new AccountEntity($this->name, $this->token);
    }
}