<?php

namespace Tests\Unit\Presenters;
use Tests\TestCase;

interface Validation {
    public function validate(string $field, string $value): ?string;
}

class LaravelAuthPresenter
{
    private Validation $validation;

    public function __construct(Validation $validation)
    {
        $this->validation = $validation;
    }

    public function validateEmail(string $email): void
    {
        $this->validation->validate(field: 'email', value: $email);
    }
}

class ValidationSpy implements Validation{
    
	/**
	 *
	 * @param string $field
	 * @param string $value
	 *
	 * @return ?string
	 */
	public function validate(string $field, string $value): ?string 
    {
        return null;
	}
}

class LaravelAuthPresenterTest extends TestCase
{
    /**
     * Should call Validation with correct email
     * 
     * @return void
     */
    public function test_should_call_validation_with_correct_email()
    {
        $validation = $this->createMock(ValidationSpy::class);
        $sut = new LaravelAuthPresenter(validation: $validation);
        $email = $this->faker->email();

        $validation->expects($this->once())
        ->method('validate')->with(field: "email", value: $email);

        $sut->validateEmail($email);
    }

}