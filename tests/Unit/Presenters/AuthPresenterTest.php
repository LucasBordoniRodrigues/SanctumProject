<?php

namespace Tests\Unit\Presenters;

use App\Lib\Data\Models\OAuthAccountModel;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use Exception;

use App\Lib\Domain\Entities\AccountEntity;
use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Helpers\DomainErrorCase;
use App\Lib\Domain\Usecases\Authentication\Authentication;
use App\Lib\Domain\Usecases\Authentication\AuthenticationParams;


use App\Lib\Presentation\Presenters\AuthPresenter;
use App\Lib\Presentation\Protocols\Validation;
use Illuminate\Routing\ResponseFactory;

class ValidationSpy implements Validation 
{
    
	/**
	 *
	 * @param string $field
	 * @param string $value
	 *
	 * @return string
	 */
	public function validate(string $field, ?string $value): ?string 
    {
        return "";
	}
}

class AuthenticationSpy implements Authentication
{
    
	/**
	 *
	 * @param AuthenticationParams $params
	 *
	 * @return AccountEntity
	 */
	public function auth(AuthenticationParams $params): AccountEntity
    {
        throw new Exception();
	}
}

class AuthPresenterTest extends TestCase
{
    private MockObject|Validation $validationSpy;
    private MockObject|Authentication $authenticationSpy;
    private AuthPresenter $sut;
    private string $email;
    private string $name;
    private string $password;

    protected function setUp(): void
    {
        $this->validationSpy = $this->createMock(ValidationSpy::class);
        $this->authenticationSpy = $this->createMock(AuthenticationSpy::class);
        $this->sut = new AuthPresenter(validation: $this->validationSpy, authentication: $this->authenticationSpy);
        $this->email = $this->faker->email();
        $this->name = $this->faker->name();
        $this->password = $this->faker->password();
    }

    /**
     * Should call Validation with correct email
     * 
     * @return void
     */
    public function test_should_call_validation_with_correct_email()
    {
        $this->validationSpy->expects($this->once())
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
        $this->validationSpy->expects($this->once())
        ->method('validate')->with("password", $this->password);

        $this->sut->validatePassword($this->password);
    }


    /**
     * Should call Authentication with correct values
     * 
     * @return void
     */
    public function test_should_call_authentication_with_correct_values()
    {

        $this->validationSpy->expects($this->exactly(2))
        ->method('validate')->withConsecutive(["email", $this->email], ["password", $this->password])
        ->willReturnOnConsecutiveCalls($this->email, $this->password);

        $this->sut->validateEmail($this->email);
        $this->sut->validatePassword($this->password);

        $this->authenticationSpy->expects($this->once())
        ->method('auth')->with(new AuthenticationParams(email: $this->email, secret: $this->password));
        
        $this->sut->auth();
    }

    /**
     * Should emit Unauthorized with invalid email or password
     * 
     * @return void
     */
    public function test_should_emit_unauthorized_with_invalid_email_or_password()
    {
        $this->validationSpy->expects($this->exactly(2))
        ->method('validate')->withConsecutive(["email", $this->email], ["password", $this->password])
        ->willReturnOnConsecutiveCalls($this->email, $this->password);

        $this->sut->validateEmail($this->email);
        $this->sut->validatePassword($this->password);

        $this->authenticationSpy->expects($this->once())
        ->method('auth')->with(new AuthenticationParams(email: $this->email, secret: $this->password))
        ->willThrowException(new DomainError(DomainErrorCase::Unauthorized));

        $this->assertEquals(new DomainError(DomainErrorCase::Unauthorized), $this->sut->auth());
    }

    /**
     * Should emit AccountEntity with valid credentials
     * 
     * @return void
     */
    public function test_should_emit_account_entity_with_valid_credentials()
    {
        $this->validationSpy->expects($this->exactly(2))
        ->method('validate')->withConsecutive(["email", $this->email], ["password", $this->password])
        ->willReturnOnConsecutiveCalls($this->email, $this->password);

        $this->sut->validateEmail($this->email);
        $this->sut->validatePassword($this->password);

        $this->authenticationSpy->expects($this->once())
        ->method('auth')->with(new AuthenticationParams(email: $this->email, secret: $this->password))
        ->willReturn((new OAuthAccountModel(name: $this->name, token: $this->email))->toEntity());

        $this->assertEquals((new OAuthAccountModel(name: $this->name, token: $this->email))->toEntity()->toArray(), $this->sut->auth());
    }
    
}