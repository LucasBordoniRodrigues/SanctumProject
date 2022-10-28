<?php

namespace Tests\Unit\Data\Usecases;

use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

use App\Lib\Data\Authenticator\OAuthClient;
use App\Lib\Data\Usecases\OAuthAuthentication;

use App\Lib\Domain\Usecases\Authentication\{AuthenticationParams};


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
    private MockInterface|OAuthClientSpy $oAuthClientSpy;
    private string $email;
    private string $secret;
    private OAuthAuthentication $sut;

    protected function setUp(): void
    {
        $this->oAuthClientSpy = Mockery::spy(OAuthClientSpy::class);
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
        $this->sut->auth($params);
    
        $this->assertNotEmpty($this->oAuthClientSpy->shouldHaveReceived('authenticate')->with($this->email, $this->secret)->once());
    }
}
