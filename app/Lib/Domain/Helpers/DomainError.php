<?php

namespace App\Lib\Domain\Helpers;

use Exception;

enum DomainErrorCase {
    case BadRequest;
    case Unauthorized;
    case Unexpected;
}

class DomainError extends Exception {
    function __construct(private DomainErrorCase $case, ?string $message = null){
        match($case){
            DomainErrorCase::BadRequest      =>    parent::__construct($message ?? "Bad Request - Invalid Data", 400),
            DomainErrorCase::Unauthorized    =>    parent::__construct($message ?? "Unauthorized - Invalid Credentials", 401),
            DomainErrorCase::Unexpected      =>    parent::__construct($message ?? "Unexpected - Internal Error", 500),
        };
    }
}