<?php 

namespace App\Lib\Validation\Protocols;

interface FieldValidation{
    public function validate(?string $value): ?string;
}