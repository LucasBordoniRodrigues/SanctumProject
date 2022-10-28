<?php

namespace App\Lib\Domain\Helpers;

use Exception;

enum DomainErrorCase {
    case BadRequest;
    case Unexpected;
}

class DomainError extends Exception {
    function __construct(private DomainErrorCase $case){
        match($case){
            DomainErrorCase::BadRequest      =>    parent::__construct("Bad Request - Invalid Data", 400),
            DomainErrorCase::Unexpected      =>    parent::__construct("Unexpected - Internal Error", 500),
        };
    }
}