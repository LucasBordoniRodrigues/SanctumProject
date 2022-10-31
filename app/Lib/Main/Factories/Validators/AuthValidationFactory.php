<?php

namespace App\Lib\Main\Factories\Validators;

use App\Lib\Presentation\Protocols\Validation;

use App\Lib\Validation\Validators\EmailValidation;
use App\Lib\Validation\Validators\RequiredFieldValidation;
use App\Lib\Validation\Validators\ValidationComposite;

class AuthValidationFactory 
{
      public static function make(): Validation
      {
            return new ValidationComposite([
                  new RequiredFieldValidation('email'),
                  new EmailValidation('email'),
                  new RequiredFieldValidation('password'),
            ]);
      }
}
