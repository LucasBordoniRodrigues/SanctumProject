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
    private EmailValidation $sut;
    private string $field;

    protected function setUp(): void
    {
        $this->field = "any_field";
        $this->sut = new EmailValidation($this->field);
    }

    /**
     * Should return null if value is empty
     * 
     * @return void
     */
    public function test_should_return_null_if_value_is_empty()
    {
        $this->assertEquals(null, $this->sut->validate("any_value")); 
    }

    /**
     * Should return null if value is null
     * 
     * @return void
     */
    public function test_should_return_null_if_value_is_null()
    {
        $this->assertEquals(null, $this->sut->validate(null)); 
    }

    /**
     * Should return null if value is valid
     * 
     * @return void
     */
    public function test_should_return_null_if_value_is_valid()
    {
        $this->assertEquals(null, $this->sut->validate($this->faker->email())); 
    }
}