<?php

namespace App\Lib\Presentation\Presenters;

use Illuminate\Http\Request;

use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Helpers\DomainErrorCase;

use App\Lib\Presentation\Protocols\Validation;

abstract class Presenter 
{
    protected Validation $validation;

    public function validateFields(array $fields): void
    {
        foreach ($fields as $field => $value) {
            $validation = $this->validation->validate(field: $field, value: $value);
        
            if($validation == null) {
                $this->$field = $value;
            } else {
                throw new DomainError(DomainErrorCase::BadRequest, message: $validation);
            }
        }
    }

    abstract public function request(Request $request);
}