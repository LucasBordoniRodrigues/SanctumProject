<?php

namespace App\Lib\Data\Usecases;

use Throwable;

use App\Lib\Data\OAuth\OAuthClient;
use App\Lib\Data\OAuth\OAuthError;

use App\Lib\Domain\Usecases\Authentication\AuthenticationParams;
use App\Lib\Domain\Entities\AccountEntity;
use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Helpers\DomainErrorCase;

class OAuthAuthentication 
{
    private OAuthClient $oAuthClient;

    public function __construct(OAuthClient $oAuthClient)
    {
        $this->oAuthClient = $oAuthClient;
    }

    public function auth(AuthenticationParams $params) : DomainError|AccountEntity
    {
        try {
            $auth = $this->oAuthClient->authenticate($params->email, $params->secret);
            return new AccountEntity(name: $auth['name'], token: $auth['token']);
        } catch (OAuthError $exception) {
            if ($exception->getCode() == 400){
                return new DomainError(DomainErrorCase::BadRequest);
            }

            if ($exception->getCode() == 401){
                return new DomainError(DomainErrorCase::Unauthorized);
            }

            return new DomainError(DomainErrorCase::Unexpected);
        } catch(Throwable $exception) {

            return new DomainError(DomainErrorCase::Unexpected);
        }
    }
}
