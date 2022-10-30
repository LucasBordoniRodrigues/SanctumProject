<?php 

namespace App\Lib\Validation\Validators;

use App\Lib\Validation\Protocols\FieldValidation;

class RequiredFieldValidation extends FieldValidation
{
    public function validate(?string $value): ?string 
    {
        return $value != null && $value != "" ? null : "$this->field is required"; 
    }
}