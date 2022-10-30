<?php 

namespace App\Lib\Validation\Validators;

use App\Lib\Validation\Protocols\FieldValidation;

class EmailValidation extends FieldValidation
{
	public function validate(?string $value): ?string 
    {
        $isValid = filter_var($value, FILTER_VALIDATE_EMAIL) || ($value == null || $value == "");
        return $isValid ? null : "$this->field is invalid";
	}
}