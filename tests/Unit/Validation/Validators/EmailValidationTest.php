<?php 

namespace Tests\Unit\Validation\Validators;
use App\Lib\Validation\Protocols\FieldValidation;
use Tests\TestCase;

class EmailValidation extends FieldValidation
{
	public function validate(?string $value): ?string 
    {
        return null;
	}
}


class EmailValidationTest extends TestCase
{

    /**
     * Should return null if value is empty
     * 
     * @return void
     */
    public function test_should_return_null_if_value_is_empty()
    {
        $sut = new EmailValidation("any_field");
        $this->assertEquals(null, $sut->validate("any_value")); 
    }

    /**
     * Should return null if value is null
     * 
     * @return void
     */
    public function test_should_return_null_if_value_is_null()
    {
        $sut = new EmailValidation("any_field");
        $this->assertEquals(null, $sut->validate(null)); 
    }
}