<?php

namespace App\Lib\Infra\OAuth;

use App\Models\User;

use App\Lib\Data\OAuth\OAuthError;
use App\Lib\Data\OAuth\OAuthErrorCase;

class OAuthAdapter
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function authenticate(string $email, string $secret): array
    {
        $user = $this->user->where(['email' => $email])->first();
        if($user != null && password_verify($secret, $user->password)){
            return ['name' => $user->name, 'token' => $user->createToken("API TOKEN")->plainTextToken];
        }
        throw new OAuthError(OAuthErrorCase::InvalidCredentials);
    }
}