<?php

namespace App\Lib\Main\Factories\Usecases\Authentication;

use App\Lib\Data\Usecases\OAuthAuthentication;
use App\Lib\Main\Factories\OAuth\OAuthClientFactory;

class AuthenticationFactory 
{

    public static function makeOAuthAuthentication(): OAuthAuthentication
    {
        return new OAuthAuthentication(oAuthClient: OAuthClientFactory::make());
    }
}