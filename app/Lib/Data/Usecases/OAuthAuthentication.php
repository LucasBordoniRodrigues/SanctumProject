<?php

namespace App\Lib\Data\Usecases;

use Throwable;

use App\Lib\Data\Models\OAuthAccountModel;
use App\Lib\Data\OAuth\OAuthClient;
use App\Lib\Data\OAuth\OAuthError;

use App\Lib\Domain\Entities\AccountEntity;
use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Helpers\DomainErrorCase;
use App\Lib\Domain\Usecases\Authentication\Authentication;
use App\Lib\Domain\Usecases\Authentication\AuthenticationParams;

class OAuthAuthentication implements Authentication
{
    private OAuthClient $oAuthClient;

    public function __construct(OAuthClient $oAuthClient)
    {
        $this->oAuthClient = $oAuthClient;
    }

    public function auth(AuthenticationParams $params) : AccountEntity
    {
        try {
            $credentials = new OAuthAuthenticationParams();
            $credentials->fromDomain($params);
            $auth = $this->oAuthClient->authenticate($credentials->email, $credentials->password);
            
            return (new OAuthAccountModel(name: $auth['name'], token: $auth['token']))->toEntity();
        } catch (OAuthError $exception) {
            if ($exception->getCode() == 400){
                throw new DomainError(DomainErrorCase::BadRequest);
            }

            if ($exception->getCode() == 401){
                throw new DomainError(DomainErrorCase::Unauthorized);
            }

            throw new DomainError(DomainErrorCase::Unexpected);
        } catch(Throwable $exception) {
            throw new DomainError(DomainErrorCase::Unexpected);
        }
    }
}

class OAuthAuthenticationParams
{
    public string $email;
    public string $password;

    public function fromDomain(AuthenticationParams $params): void
    {
        $this->email = $params->email;
        $this->password = $params->secret;
    }
}
