<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_without_activating_user(): void
    {
        $user = User::factory()->create();
        $data = [
            'phone' => $user->phone,
            'password' => $user->password
        ];
        $response = $this->post('api/login', $data);
        $response->assertStatus(401);
    }

    public function test_login(): void
    {
        $user = User::factory()->create();
        $data = [
            'phone' => $user->phone,
            'password' => 2631
        ];
        $response = $this->post('api/login', $data);
        $data = json_decode($response->getContent(), true);
        $response->assertStatus(200);
        $this->assertNotNull($data['token']);
    }


    public function test_login_with_wrong_pass(): void
    {
        $data = [
            'phone' => '(613) 327-8306',
            'password' => '2635'
        ];
        $response = $this->post('api/login', $data);
        $response->assertStatus(401);
    }

    public function test_logout(): void
    {
        $user = User::factory()->create();
        $data = [
            'phone' => $user->phone,
            'password' => 2631
        ];
        $response = $this->post('api/login', $data);
        $data = json_decode($response->getContent(), true);
        $data = [
            'token' => $data['token']
        ];
        $response = $this->post('api/logout', $data);
        $response->assertStatus(200);
    }
}