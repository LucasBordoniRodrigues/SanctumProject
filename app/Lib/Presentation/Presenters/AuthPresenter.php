<?php

namespace App\Lib\Presentation\Presenters;

use Illuminate\Http\Request;

use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Helpers\DomainErrorCase;
use App\Lib\Domain\Usecases\Authentication\Authentication;
use App\Lib\Domain\Usecases\Authentication\AuthenticationParams;

use App\Lib\Presentation\Protocols\Validation;

class AuthPresenter
{
    private Validation $validation;
    private Authentication $authentication;
    private ?string $email;
    private ?string $password;

    public function __construct(Validation $validation, Authentication $authentication)
    {
        $this->validation = $validation;
        $this->authentication = $authentication;
    }

    public function request(Request $request)
    {
        $requestData = $request->all(['email', 'password']);
        
        try {
            $this->validateEmail($requestData['email']);
            $this->validatePassword($requestData['password']);
            return response()->json($this->auth());
        } catch (\Throwable $e) {
            return response()->json(["exception" => $e->getMessage()], $e->getCode());
        }
    }

    public function validateEmail(?string $email): void
    {
        $validation = $this->validation->validate(field: 'email', value: $email);
        if($validation == null) {
            $this->email = $email;
        } else {
            throw new DomainError(DomainErrorCase::BadRequest, message: $validation);
        }
    }

    public function validatePassword(?string $password): void
    {
        $validation = $this->validation->validate(field: 'password', value: $password);

        if($validation == null) {
            $this->password = $password;
        } else {
            throw new DomainError(DomainErrorCase::BadRequest, message: $validation);
        }
    }

    public function auth()
    {
        try {
            $account = $this->authentication->auth(new AuthenticationParams(email: $this->email, secret: $this->password));
            return $account->toArray();
        }catch(DomainError $e){
            throw $e;
        }
    }
}