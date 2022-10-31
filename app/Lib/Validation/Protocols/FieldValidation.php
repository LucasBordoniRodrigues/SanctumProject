<?php 

namespace App\Lib\Validation\Protocols;

abstract class FieldValidation
{

    public string $field;
    
    public function __construct(string $field)
    {
        $this->field = $field;
    }
    abstract public function validate(?string $value): ?string;
}