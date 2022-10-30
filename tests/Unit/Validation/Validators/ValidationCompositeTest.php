<?php 

namespace Tests\Unit\Validation\Validators;
use App\Lib\Presentation\Protocols\Validation;
use App\Lib\Validation\Protocols\FieldValidation;
use Tests\TestCase;

class ValidationComposite implements Validation 
{
    private array $validations;

    public function __construct(array $validations)
    {
        $this->validations = $validations;
    }

	public function validate(string $field, ?string $value): ?string 
    {
        return null;
	}
}

class FieldValidationSpy extends FieldValidation
{
    
	/**
	 *
	 * @param ?string $value
	 *
	 * @return ?string
	 */
	public function validate(?string $value): ?string {
        return null;
	}
}

class ValidationCompositeTest extends TestCase
{
    /**
     * Should return null or empty if all validations return null or empty
     * 
     * @return void
     */
    public function test_should_return_null_or_empty_if_all_validations_return_null_or_empty()
    {
      
        $validation1 = $this->createMock(FieldValidationSpy::class);
        $validation1->field = "any_field";

        $validation1
        ->method("validate")->willReturn(null);
        
        $validation2 = $this->createMock(FieldValidationSpy::class);
        $validation2->field = "any_field";


        $validation2
        ->method("validate")->willReturn("");

        $sut = new ValidationComposite([$validation1, $validation2]);


        $this->assertEquals(null, $sut->validate(field: "any_field", value: "any_value"));
    }

}