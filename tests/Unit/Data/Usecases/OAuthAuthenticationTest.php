<?php

namespace Tests\Unit\Data\Usecases;

use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

use App\Lib\Data\OAuth\OAuthClient;
use App\Lib\Data\OAuth\OAuthError;
use App\Lib\Data\OAuth\OAuthErrorCase;
use App\Lib\Data\Usecases\OAuthAuthentication;
use App\Lib\Domain\Helpers\DomainError;
use App\Lib\Domain\Helpers\DomainErrorCase;
use App\Lib\Domain\Usecases\Authentication\{AuthenticationParams};
use Exception;
use PHPUnit\Framework\MockObject\MockObject;

class OAuthClientSpy extends OAuthClient
{	
    /**
	 * Authenticate client
     * 
	 * @param string $email
	 * @param string $secret
	 *
	 * @return mixed
	 */
	public function authenticate(string $email, string $secret) {
    }
}

class OAuthAuthenticationTest extends TestCase
{
    private MockObject|OAuthClientSpy $oAuthClientSpy;
    private string $email;
    private string $secret;
    private OAuthAuthentication $sut;

    protected function setUp(): void
    {
        $this->oAuthClientSpy = $this->createMock(OAuthClientSpy::class);
        $this->email = $this->faker->email();
        $this->secret = $this->faker->password();
        $this->sut = new OAuthAuthentication(oAuthClient: $this->oAuthClientSpy);
    }

    /**
     * Should call OAuthClient with correct credentials format.
     * 
     * @return void
     */
    public function test_should_call_oauthclient_with_correct_credentials()
    {
        $params = new AuthenticationParams(email: $this->email, secret: $this->secret);
        $this->oAuthClientSpy->expects($this->once())
        ->method('authenticate');
        
        $this->sut->auth($params);
    }

    /**
     * Should throw BadRequest if OAuthError returns Invalid Data.
     * 
     * @return void
     */
    public function test_should_throw_bad_request_if_o_auth_error_returns_invalid_data()
    {
        $params = new AuthenticationParams(email: $this->email, secret: $this->secret);
        $this->oAuthClientSpy->expects($this->once())
        ->method('authenticate')
        ->will($this->throwException(new OAuthError(OAuthErrorCase::InvalidData)));

        $this->assertEquals($this->sut->auth($params), new DomainError(DomainErrorCase::BadRequest));
    }

    /**
     * Should throw InternalError if OAuthError returns Unexpected Exception.
     * 
     * @return void
     */
    public function test_should_throw_internal_error_if_o_auth_error_returns_unexpected_exception()
    {
        $params = new AuthenticationParams(email: $this->email, secret: $this->secret);
        $this->oAuthClientSpy->expects($this->once())
        ->method('authenticate')
        ->will($this->throwException(new Exception()));

        $this->assertEquals($this->sut->auth($params), new DomainError(DomainErrorCase::Unexpected));
    }

    /**
     * Should throw Unauthorized if OAuthError returns Invalid Credentials.
     * 
     * @return void
     */
    public function test_should_throw_unauthorized_if_o_auth_error_returns_invalid_credentials()
    {
        $params = new AuthenticationParams(email: $this->email, secret: $this->secret);
        $this->oAuthClientSpy->expects($this->once())
        ->method('authenticate')
        ->will($this->throwException(new OAuthError(OAuthErrorCase::InvalidCredentials)));

        $this->assertEquals($this->sut->auth($params), new DomainError(DomainErrorCase::Unauthorized));
    }

    
  
}
