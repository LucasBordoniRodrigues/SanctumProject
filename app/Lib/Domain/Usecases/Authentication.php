<?php

namespace App\Lib\Usecases;

use App\Lib\Entities\{AccountEntity};

interface Authentication 
{
    public function auth(string $username, string $secret): AccountEntity;
}