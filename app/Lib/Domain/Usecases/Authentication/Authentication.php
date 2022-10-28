<?php

namespace App\Lib\Domain\Usecases\Authentication;

use App\Lib\Entities\{AccountEntity};

interface Authentication 
{
    public function auth(AuthenticationParams $params): AccountEntity;
}
