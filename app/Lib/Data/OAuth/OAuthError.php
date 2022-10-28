<?php

namespace App\Lib\Data\OAuth;

use Exception;

enum OAuthErrorCase 
{
    case invalidData;
}

class OAuthError extends Exception 
{
    function __construct(private OAuthErrorCase $case) 
    {
        match($case){
            OAuthErrorCase::invalidData      =>    parent::__construct("Invalid Data", 400),
        };
    }
}