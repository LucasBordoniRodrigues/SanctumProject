<?php

namespace App\Lib\Presentation\Protocols;

interface Validation {
    public function validate(string $field, string $value): ?string;
}
