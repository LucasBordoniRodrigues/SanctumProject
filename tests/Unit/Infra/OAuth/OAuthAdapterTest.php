<?php

namespace Tests\Unit\Infra\OAuth;

use App\Lib\Data\OAuth\OAuthError;
use App\Lib\Data\OAuth\OAuthErrorCase;
use App\Lib\Infra\OAuth\OAuthAdapter;
use App\Models\User;
use Exception;
use Tests\TestCase;

class OAuthAdapterTest extends TestCase
{
    private OAuthAdapter $sut;
    private User $user;
    private string $email;
    private string $secret;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
        $this->sut = new OAuthAdapter($this->user);
    }

    private function validCredentials()
    {
        $this->email = "admin@admin.com";
        $this->secret = "123";
    }

    private function invalidCredentials()
    {
        $this->email = "admin@admin.com";
        $this->secret = "errorPass";
    }

    /**
     * Should call authenticate with valid credentials
     * 
     * @return void
     */
    public function test_should_call_authenticate_with_valid_credentials()
    {
        $this->validCredentials();
        $this->assertArrayHasKey('name', $this->sut->authenticate(email: $this->email, secret: $this->secret));
        $this->assertArrayHasKey('token', $this->sut->authenticate(email: $this->email, secret: $this->secret));
    }


    /**
     * Should throw InvalidCredentials if OAuthClientAdapter receive invalid credentials
     * 
     * @return void
     */
    public function test_should_throw_invalid_credentials_if_o_auth_client_adapters_receive_invalid_credentials()
    {
        $this->invalidCredentials();
        $this->expectException(OAuthError::class);
        $this->sut->authenticate(email: $this->email, secret: $this->secret);
    }
}