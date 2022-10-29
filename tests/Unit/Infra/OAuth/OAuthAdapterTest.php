<?php

namespace Tests\Unit\Infra\OAuth;

use App\Lib\Infra\OAuth\OAuthAdapter;
use App\Models\User;
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

    /**
     * Should call authenticate with correct values
     * 
     * @return void
     */
    public function test_should_call_authenticate_with_correct_values()
    {
        $this->validCredentials();
        $this->assertArrayHasKey('name', $this->sut->authenticate(email: $this->email, secret: $this->secret));
        $this->assertArrayHasKey('token', $this->sut->authenticate(email: $this->email, secret: $this->secret));
    }
}