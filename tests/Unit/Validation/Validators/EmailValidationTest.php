<?php 

namespace Tests\Unit\Validation\Validators;

use Tests\TestCase;

use App\Lib\Validation\Validators\EmailValidation;

class EmailValidationTest extends TestCase
{
    private EmailValidation $sut;
    private string $field;

    protected function setUp(): void
    {
        $this->field = "any_field";
        $this->sut = new EmailValidation($this->field);
    }

    /**
     * Should return null if email is empty
     * 
     * @return void
     */
    public function test_should_return_null_if_email_is_empty()
    {
        $this->assertEquals(null, $this->sut->validate("")); 
    }

    /**
     * Should return null if email is null
     * 
     * @return void
     */
    public function test_should_return_null_if_email_is_null()
    {
        $this->assertEquals(null, $this->sut->validate(null)); 
    }

    /**
     * Should return null if email is valid
     * 
     * @return void
     */
    public function test_should_return_null_if_email_is_valid()
    {
        $this->assertEquals(null, $this->sut->validate($this->faker->email())); 
    }

    /**
     * Should return error if email is invalid
     * 
     * @return void
     */
    public function test_should_return_error_if_email_is_invalid()
    {
        $this->assertEquals("$this->field is invalid", $this->sut->validate("invalid_mail")); 
    }
}