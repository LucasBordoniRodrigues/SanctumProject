<?php 

namespace Tests\Unit\Validation\Validators;
use App\Lib\Presentation\Protocols\Validation;
use App\Lib\Validation\Protocols\FieldValidation;
use PHPUnit\Framework\MockObject\MockObject;
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
        $error = null;
        foreach ($this->validations as $validation) {
            if($validation->field == $field){
                $error = $validation->validate($value);
                if($error != null && $error != ""){
                    return $error;
                }
            }
        }
        return $error;
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
    private ValidationComposite $sut;
    private MockObject|FieldValidation $validation1;
    private MockObject|FieldValidation $validation2;
    private MockObject|FieldValidation $validation3;

    protected function setUp(): void
    {
        $this->validation1 = $this->createMock(FieldValidationSpy::class);
        $this->validation1->field = "other_field";

        $this->validation2 = $this->createMock(FieldValidationSpy::class);
        $this->validation2->field = "any_field";

        $this->validation3 = $this->createMock(FieldValidationSpy::class);
        $this->validation3->field = "any_field";

        $this->sut = new ValidationComposite([$this->validation1, $this->validation2, $this->validation3]);
    }

    private function mockValidation1(?string $error)
    {
        $this->validation1
        ->method("validate")->willReturn($error);
    }

    private function mockValidation2(?string $error)
    {
        $this->validation2
        ->method("validate")->willReturn($error);
    }

    private function mockValidation3(?string $error)
    {
        $this->validation3
        ->method("validate")->willReturn($error);
    }

    /**
     * Should return null or empty if all validations return null or empty
     * 
     * @return void
     */
    public function test_should_return_null_or_empty_if_all_validations_return_null_or_empty()
    {
        $this->mockValidation1(null);
        $this->mockValidation2(null);
        $this->mockValidation3(null);

        $this->assertEquals(null, $this->sut->validate(field: "any_field", value: "any_value"));
    }

    /**
     * Should return first error 
     * 
     * @return void
     */
    public function test_should_return_first_error()
    {
        $this->mockValidation1("error_1");
        $this->mockValidation2("error_2");
        $this->mockValidation3("error_3");

        $this->assertEquals("error_2", $this->sut->validate(field: "any_field", value: "any_value"));
    }


    /**
     * Should return first error of the field
     * 
     * @return void
     */
    public function test_should_return_first_error_of_the_field()
    {
        $this->mockValidation1("error_1");
        $this->mockValidation2("error_2");
        $this->mockValidation3("error_3");

        $this->assertEquals("error_1", $this->sut->validate(field: "other_field", value: "any_value"));
    }

}