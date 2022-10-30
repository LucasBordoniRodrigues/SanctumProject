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
    private ValidationComposite $sut;
    private MockObject|FieldValidation $validation1;
    private MockObject|FieldValidation $validation2;
    private MockObject|FieldValidation $validation3;

    protected function setUp(): void
    {
        $this->validation1 = $this->createMock(FieldValidationSpy::class);
        $this->validation1->field = "any_field";
        $this->mockValidation1(null);

        $this->validation2 = $this->createMock(FieldValidationSpy::class);
        $this->validation2->field = "any_field";
        $this->mockValidation2(null);

        $this->validation3 = $this->createMock(FieldValidationSpy::class);
        $this->validation3->field = "other_field";
        $this->mockValidation3(null);

        $this-> sut = new ValidationComposite([$this->validation1, $this->validation2, $this->validation3]);
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
        $this->mockValidation2("");
        $this->assertEquals(null, $this->sut->validate(field: "any_field", value: "any_value"));
    }

}