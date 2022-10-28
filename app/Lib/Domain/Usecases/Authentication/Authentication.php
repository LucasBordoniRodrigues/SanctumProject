<?php

namespace App\Lib\Domain\Usecases\Authentication;

use App\Lib\Domain\Entities\AccountEntity;
use App\Lib\Domain\Helpers\DomainError;

interface Authentication 
{
    public function auth(AuthenticationParams $params): DomainError|AccountEntity;
}
