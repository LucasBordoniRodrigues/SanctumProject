<?php

namespace App\Lib\Presentation\Presenters;

use Illuminate\Http\Request;

use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Usecases\Authentication\Authentication;
use App\Lib\Domain\Usecases\Authentication\AuthenticationParams;

use App\Lib\Presentation\Protocols\Validation;

class AuthPresenter extends Presenter
{
    private Authentication $authentication;
    protected string $email;
    protected string $password;

    public function __construct(Validation $validation, Authentication $authentication)
    {
        $this->validation = $validation;
        $this->authentication = $authentication;
    }

    public function request(Request $request)
    {
        $requestData = $request->all(['email', 'password']);
        
        try {
            $this->validateFields($requestData);
            return response()->json($this->auth());
        } catch (\Throwable $e) {
            return response()->json(["exception" => $e->getMessage()], $e->getCode() != 0 ? $e->getCode() : 500);
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