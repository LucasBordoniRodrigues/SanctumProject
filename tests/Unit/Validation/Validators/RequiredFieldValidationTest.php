<?php

namespace Tests\Unit\Validation\Validators;

use Tests\TestCase;

use App\Lib\Validation\Validators\RequiredFieldValidation;

class RequiredFieldValidationTest extends TestCase
{
    private RequiredFieldValidation $sut;
    private string $field;

    public function setUp(): void 
    {
        $this->field = "any_field";
        $this->sut = new RequiredFieldValidation($this->field);
    }

    /**
     * Should return null if value is not empty
     * 
     * @return void
     */
    public function test_should_return_null_if_value_is_not_empty()
    {
        $this->assertEquals(null, $this->sut->validate("any_value")); 
    }

    /**
     * Should return error if value is empty
     * 
     * @return void
     */
    public function test_should_return_error_if_value_is_empty()
    {
        $this->assertEquals("$this->field is required", $this->sut->validate("")); 
    }

    /**
     * Should return error if value is null
     * 
     * @return void
     */
    public function test_should_return_error_if_value_is_null()
    {
        $this->assertEquals("$this->field is required", $this->sut->validate(null)); 
    }
}