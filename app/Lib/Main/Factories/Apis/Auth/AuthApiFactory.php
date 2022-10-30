<?php 

namespace App\Lib\Main\Factories\Apis\Auth;

use App\Lib\Main\Factories\Usecases\Authentication\AuthenticationFactory;
use App\Lib\Presentation\Presenters\AuthPresenter;
use Illuminate\Http\Request;

class AuthApiFactory
{
    public function makeAuthApi(Request $request)
    {
        $oAuthAuthentication = AuthenticationFactory::makeOAuthAuthentication();
        $validationComposite = AuthValidationFactory::make();
        
        return (new AuthPresenter(
            authentication: $oAuthAuthentication,
            validation: $validationComposite
        ))->request($request);
    }
}