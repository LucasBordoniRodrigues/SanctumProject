<?php

namespace App\Lib\Data\OAuth;

use Exception;

enum OAuthErrorCase 
{
    case InvalidData;
    case InvalidCredentials;
}

class OAuthError extends Exception 
{
    function __construct(private OAuthErrorCase $case) 
    {
        match($case){
            OAuthErrorCase::InvalidData        => parent::__construct("Invalid Data", 400),
            OAuthErrorCase::InvalidCredentials => parent::__construct("Invalid Credentials", 401),
        };
    }
}