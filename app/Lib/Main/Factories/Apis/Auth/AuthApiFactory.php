<?php

namespace App\Lib\Main\Factories\Apis\Auth;

use Illuminate\Http\Request;
use App\Lib\Main\Factories\Usecases\Authentication\AuthenticationFactory;
use App\Lib\Main\Factories\Validators\AuthValidationFactory;
use App\Lib\Presentation\Presenters\LaravelAuthPresenter;

class AuthApiFactory
{
    public function makeLaravelApi(Request $request)
    {
        $oAuthAuthentication = AuthenticationFactory::makeOAuthAuthentication();
        $validationComposite = AuthValidationFactory::make();

        return (new LaravelAuthPresenter(
            authentication: $oAuthAuthentication,
            validation: $validationComposite
        ))->request($request);
    }
}
