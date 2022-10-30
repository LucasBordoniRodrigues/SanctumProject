<?php

namespace Tests\Unit\Validation\Validators;
use Tests\TestCase;

interface FieldValidation{
    public function validate(string $value): ?string;
}

class RequiredFieldValidation implements FieldValidation
{
    public string $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    public function validate(string $value): ?string 
    {
        return null;
    }
}

class RequiredFieldValidationTest extends TestCase
{
    /**
     * Should return null if value is not empty
     * 
     * @return void
     */
    public function test_should_return_null_if_value_is_not_empty()
    {
        $sut = new RequiredFieldValidation("any_field");

        $error = $sut->validate("any_value");

        $this->assertEquals(null, $error); 
    }
}