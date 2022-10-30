<?php 

namespace App\Lib\Main\Factories\Apis\Auth;

use App\Lib\Data\Usecases\OAuthAuthentication;
use App\Lib\Infra\OAuth\OAuthAdapter;
use App\Lib\Presentation\Presenters\AuthPresenter;
use App\Lib\Validation\Validators\EmailValidation;
use App\Lib\Validation\Validators\RequiredFieldValidation;
use App\Lib\Validation\Validators\ValidationComposite;
use App\Models\User;
use Illuminate\Http\Request;

class AuthApiFactory
{
    public function makeAuthApi(Request $request)
    {
        $user = new User();
        $oAuthAdapter = new OAuthAdapter(user: $user);
        $oAuthAuthentication = new OAuthAuthentication(oAuthClient: $oAuthAdapter);
        $validationComposite = new ValidationComposite([
            new RequiredFieldValidation('email'),
            new EmailValidation('email'),
            new RequiredFieldValidation('password'),
        ]);
        return (new AuthPresenter(
            authentication: $oAuthAuthentication,
            validation: $validationComposite
        ))->request($request);
    }
}