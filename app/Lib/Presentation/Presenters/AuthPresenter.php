<?php

namespace App\Lib\Presentation\Presenters;

use App\Lib\Presentation\Protocols\Validation;

class AuthPresenter
{
    private Validation $validation;

    public function __construct(Validation $validation)
    {
        $this->validation = $validation;
    }

    public function validateEmail(string $email): void
    {
        $this->validation->validate(field: 'email', value: $email);
    }
}