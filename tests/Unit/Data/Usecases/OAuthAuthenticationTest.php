<?php

namespace Tests\Unit\Data\Usecases;

use Mockery;
use Mockery\MockInterface;
use Phockito;
use Tests\TestCase;

class OAuthAuthentication 
{
    private OAuthClient $oAuthClient;
    private string $email;
    private string $secret;

    public function __construct(OAuthClient $oAuthClient, string $email, string $secret)
    {
        $this->oAuthClient = $oAuthClient;
        $this->email = $email;
        $this->secret = $secret;
    }

    public function auth() {
        return $this->oAuthClient->authenticate($this->email, $this->secret);
    }
}

abstract class OAuthClient 
{
    abstract public function authenticate(string $email, string $secret);
}

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
        $this->secret = $this->faker->secret();
        $this->sut = new OAuthAuthentication(oAuthClient: $this->oAuthClientSpy, email: $this->email, secret: $this->secret);
    }

    /**
     * Should call OAuthClient with correct credentials format.
     * 
     * @return void
     */
    public function test_should_call_oauthclient_with_correct_credentials()
    {
        $this->sut->auth();
    
        $this->assertNotEmpty($this->oAuthClientSpy->shouldHaveReceived('authenticate')->with($this->email, $this->secret)->once());
    }
}
