<?php

namespace App\Lib\Presentation\Presenters;

use App\Http\Controllers\Controller;

use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Usecases\Authentication\Authentication;
use App\Lib\Domain\Usecases\Authentication\AuthenticationParams;

use App\Lib\Presentation\Protocols\Validation;

class AuthPresenter
{
    private Validation $validation;
    private Authentication $authentication;
    private string $email;
    private string $password;

    public function __construct(Validation $validation, Authentication $authentication)
    {
        $this->validation = $validation;
        $this->authentication = $authentication;
    }

    public function validateEmail(string $email): void
    {
        $this->email = $this->validation->validate(field: 'email', value: $email);
    }

    public function validatePassword(string $password): void
    {
        $this->password = $this->validation->validate(field: 'password', value: $password);
    }

    public function auth()
    {
        try {
            $account = $this->authentication->auth(new AuthenticationParams(email: $this->email, secret: $this->password));
            return $account->toArray();
        }catch(DomainError $e){
            return $e;
        }
    }
}