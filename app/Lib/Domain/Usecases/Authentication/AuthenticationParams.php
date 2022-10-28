<?php

namespace App\Lib\Domain\Usecases\Authentication;

class AuthenticationParams
{
    public string $email;
    public string $secret;

    public function __construct(string $email, string $secret)
    {
        $this->email = $email;
        $this->secret = $secret;
    }

    public function toJson(): object {
        return json_decode('
            {
                "email": '.$this->email.',
                "password": '.$this->secret.',
            }
        ');
    }
}