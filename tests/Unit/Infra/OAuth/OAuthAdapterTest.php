<?php

namespace Tests\Unit\Infra\OAuth;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class OAuthAdapter
{
    public function authenticate(string $email, string $secret): void
    {
        $credentials = ["email" => $email, "password" => $secret];
        Auth::attempt($credentials);
    }
}

class OAuthAdapterTest extends TestCase
{
    /**
     * Should call authenticate with correct values
     * 
     * @return void
     */
    public function test_should_call_authenticate_with_correct_values()
    {
        $sut = new OAuthAdapter();
        $email = $this->faker->email();
        $secret = $this->faker->password();

        Auth::shouldReceive('attempt')->once()->with(["email" => $email, "password" => $secret])->andReturn(true);

        $sut->authenticate(email: $email, secret: $secret);
    }
}