<?php

namespace App\Lib\Data\Usecases;

use App\Lib\Domain\Usecases\Authentication\AuthenticationParams;

use App\Lib\Data\OAuth\OAuthClient;

class OAuthAuthentication 
{
    private OAuthClient $oAuthClient;

    public function __construct(OAuthClient $oAuthClient)
    {
        $this->oAuthClient = $oAuthClient;
    }

    public function auth(AuthenticationParams $params) 
    {
        return $this->oAuthClient->authenticate($params->email, $params->secret);
    }
}
