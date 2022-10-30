<?php

namespace App\Lib\Main\Factories\OAuth;

use App\Models\User;

use App\Lib\Data\OAuth\OAuthClient;
use App\Lib\Infra\OAuth\OAuthAdapter;

class OAuthClientFactory 
{
    public static function make(): OAuthClient
    {
        return new OAuthAdapter(new User());
    }
}
