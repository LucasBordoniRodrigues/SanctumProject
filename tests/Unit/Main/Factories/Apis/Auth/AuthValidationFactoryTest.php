<?php

namespace Tests\Unit\Main\Factories\Apis\Auth;

use Tests\TestCase;
use App\Lib\Main\Factories\Validators\AuthValidationFactory;
use App\Lib\Validation\Validators\EmailValidation;
use App\Lib\Validation\Validators\RequiredFieldValidation;
use App\Lib\Validation\Validators\ValidationComposite;

class AuthValidationFactoryTest extends TestCase
{
    /**
     * Should return the correct validation
     *
     * @return void
     */
    public function test_should_return_the_correct_validation()
    {
        $this->assertEquals(new ValidationComposite([
            new RequiredFieldValidation('email'),
            new EmailValidation('email'),
            new RequiredFieldValidation('password'),
        ]), AuthValidationFactory::make());
    }
}
