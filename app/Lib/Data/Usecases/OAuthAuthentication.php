<?php

namespace App\Lib\Data\Usecases;

use App\Lib\Domain\Usecases\Authentication\AuthenticationParams;

use App\Lib\Data\OAuth\OAuthClient;
use App\Lib\Data\OAuth\OAuthError;
use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Helpers\DomainErrorCase;
use Exception;
use Throwable;

class OAuthAuthentication 
{
    private OAuthClient $oAuthClient;

    public function __construct(OAuthClient $oAuthClient)
    {
        $this->oAuthClient = $oAuthClient;
    }

    public function auth(AuthenticationParams $params) 
    {
        try {
            $auth = $this->oAuthClient->authenticate($params->email, $params->secret);
            return $auth;
        } catch (OAuthError $exception) {
            if ($exception->getCode() == 400){
                return new DomainError(DomainErrorCase::BadRequest);
            }

            return new DomainError(DomainErrorCase::Unexpected);
        } catch(Throwable $exception) {

            return new DomainError(DomainErrorCase::Unexpected);
        }
    }
}
