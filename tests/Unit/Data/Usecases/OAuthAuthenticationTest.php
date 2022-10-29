<?php

namespace Tests\Unit\Data\Usecases;

use Tests\TestCase;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;

use App\Lib\Data\OAuth\OAuthClient;
use App\Lib\Data\OAuth\OAuthError;
use App\Lib\Data\OAuth\OAuthErrorCase;
use App\Lib\Data\Usecases\OAuthAuthentication;

use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Helpers\DomainErrorCase;
use App\Lib\Domain\Usecases\Authentication\{AuthenticationParams};

class OAuthClientSpy implements OAuthClient
{	
    /**
	 * Authenticate client
     * 
	 * @param string $email
	 * @param string $secret
	 *
	 * @return mixed
	 */
	public function authenticate(string $email, string $secret): array 
    {
        return [];
    }
}

class OAuthAuthenticationTest extends TestCase
{
    private MockObject|OAuthClientSpy $oAuthClientSpy;
    private AuthenticationParams $params;
    private OAuthAuthentication $sut;
    private string $name;
    private string $email;
    private string $secret;
    private string $token;
    private array $mockValidData;


    protected function setUp(): void
    {
        $this->oAuthClientSpy = $this->createMock(OAuthClientSpy::class);
        $this->name = $this->faker->name();
        $this->email = $this->faker->email();
        $this->secret = $this->faker->password();
        $this->token = "123MilhasToken";
        $this->params = new AuthenticationParams(email: $this->email, secret: $this->secret);
        $this->sut = new OAuthAuthentication(oAuthClient: $this->oAuthClientSpy);
        $this->mockValidData = ["name" => $this->name, "token" => $this->token];
    }

    private function mockAuthenticationCall()
    {
        return $this->oAuthClientSpy->expects($this->once())
        ->method('authenticate');
    }

    private function successCase()
    {
        $this->mockAuthenticationCall()
        ->will($this->returnValue($this->mockValidData));
    }

    private function errorCase(Exception $error)
    {
        $this->mockAuthenticationCall()
        ->will($this->throwException($error));
    }


    /**
     * Should call OAuthClient with correct credentials format.
     * 
     * @return void
     */
    public function test_should_call_oauthclient_with_correct_credentials()
    {
        $this->successCase();

        $this->sut->auth($this->params);
    }

    /**
     * Should throw BadRequest if OAuthClient returns Invalid Data.
     * 
     * @return void
     */
    public function test_should_throw_bad_request_if_o_auth_client_returns_invalid_data()
    {
        $this->errorCase(new OAuthError(OAuthErrorCase::InvalidData));
        
        $this->expectException(DomainError::class);

        $this->sut->auth($this->params);
    }

    /**
     * Should throw InternalError if OAuthClient returns Unexpected Exception.
     * 
     * @return void
     */
    public function test_should_throw_internal_error_if_o_auth_client_returns_unexpected_exception()
    {
        $this->errorCase(new Exception());

        $this->expectException(DomainError::class);

        $this->sut->auth($this->params);
    }

    /**
     * Should throw Unauthorized if OAuthClient returns Invalid Credentials.
     * 
     * @return void
     */
    public function test_should_throw_unauthorized_if_o_auth_client_returns_invalid_credentials()
    {
        $this->errorCase(new OAuthError(OAuthErrorCase::InvalidCredentials));

        $this->expectException(DomainError::class);

        $this->sut->auth($this->params);
    }

    /**
     * Should return AccountEntity if OAuth login success.
     * 
     * @return void
     */
    public function test_should_return_account_entity_if_o_auth_login_success()
    {
        $this->successCase();

        $account = $this->sut->auth($this->params);
        $this->assertEquals($account->token, $this->token);
    }

    /**
     * Should throw InternalError if OAuthClient returns success but invalid response
     * 
     * @return void
     */
    public function test_should_throw_internal_error_if_o_auth_client_returns_success_but_invalid_response()
    {
        $this->oAuthClientSpy->expects($this->once())
        ->method('authenticate')
        ->will($this->returnValue(["invalid_name" => $this->name, "invalid_token" => $this->token]));


        $this->expectException(DomainError::class);

        $this->sut->auth($this->params);
    }
}
