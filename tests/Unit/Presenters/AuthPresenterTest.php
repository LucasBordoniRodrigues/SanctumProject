<?php

namespace Tests\Unit\Presenters;

use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

use App\Lib\Presentation\Presenters\AuthPresenter;
use App\Lib\Presentation\Protocols\Validation;

class ValidationSpy implements Validation 
{
    
	/**
	 *
	 * @param string $field
	 * @param string $value
	 *
	 * @return string
	 */
	public function validate(string $field, string $value): string 
    {
        return "";
	}
}

class AuthPresenterTest extends TestCase
{
    private MockObject|Validation $validation;
    private AuthPresenter $sut;
    private string $email;
    private string $password;

    protected function setUp(): void
    {
        $this->validation = $this->createMock(ValidationSpy::class);
        $this->sut = new AuthPresenter(validation: $this->validation);
        $this->email = $this->faker->email();
        $this->password = $this->faker->password();
    }

    /**
     * Should call Validation with correct email
     * 
     * @return void
     */
    public function test_should_call_validation_with_correct_email()
    {
        $this->validation->expects($this->once())
        ->method('validate')->with("email", $this->email);

        $this->sut->validateEmail($this->email);
    }

    /**
     * Should call Validation with correct password
     * 
     * @return void
     */
    public function test_should_call_validation_with_correct_password()
    {
        $this->validation->expects($this->once())
        ->method('validate')->with("password", $this->password);

        $this->sut->validatePassword($this->password);
    }
}