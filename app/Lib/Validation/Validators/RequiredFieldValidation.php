<?php 

namespace App\Lib\Validation\Validators;

use App\Lib\Validation\Protocols\FieldValidation;

class RequiredFieldValidation implements FieldValidation
{
    public string $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    public function validate(?string $value): ?string 
    {
        return $value != null && $value != "" ? null : "$this->field is required"; 
    }
}