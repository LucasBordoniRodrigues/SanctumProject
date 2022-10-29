<?php

namespace Tests\Unit\Infra\OAuth;

use App\Lib\Data\OAuth\OAuthError;
use App\Lib\Data\OAuth\OAuthErrorCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OAuthAdapter
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function authenticate(string $email, string $secret): array
    {
        $user = $this->user->where(['email' => $email])->first();
        if($user != null && password_verify($secret, $user->password)){
            return ['name' => $user->name, 'token' => $user->createToken("API TOKEN")->plainTextToken];
        }
        throw new OAuthError(OAuthErrorCase::InvalidCredentials);
    }
}

class OAuthAdapterTest extends TestCase
{
    private string $email;
    private string $secret;
    private OAuthAdapter $sut;
    
    protected function setUp(): void
    {
        $this->email = "admin@admin.com";
        $this->secret = "123";
        $this->sut = new OAuthAdapter(new User());
    }

    /**
     * Should call authenticate with correct values
     * 
     * @return void
     */
    public function test_should_call_authenticate_with_correct_values()
    {
        $this->assertArrayHasKey('name', $this->sut->authenticate(email: $this->email, secret: $this->secret));
        $this->assertArrayHasKey('token', $this->sut->authenticate(email: $this->email, secret: $this->secret));
    }
}