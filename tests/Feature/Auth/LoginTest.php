<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register()
    {
        $data = [
            'name' => 'Mert Metin',
            'phone' => '(613) 327-8306',
            'email' => 'mertmetin@outlook.com',
            'password' => '2631'
        ];

        $response = $this->post('api/users', $data);
        $response->assertStatus(201);
        $data = json_decode($response->getContent(), true);

        return $data;
    }

    public function test_login_without_activating_user()
    {
        $data = [
            'phone' => '(613) 327-8306',
            'password' => '2631'
        ];
        $response = $this->post('api/login', $data);
        $response->assertStatus(401);
    }

    /**
     * @depends test_register
     */
    public function test_activate_user($data)
    {
        $userId = $data['id'];
        $response = $this->patch("api/users/$userId/activate", $data);
        $response->assertStatus(200);
    }

    public function test_login()
    {
        $data = [
            'phone' => '(613) 327-8306',
            'password' => '2631'
        ];
        $response = $this->post('api/login', $data);
        $data = json_decode($response->getContent(), true);
        $token = $data['token'];
        $this->assertNotNull($token);
        $response->assertStatus(200);

        return $token;
    }


    public function test_login_with_wrong_pass()
    {
        $data = [
            'phone' => '(613) 327-8306',
            'password' => '2635'
        ];
        $response = $this->post('api/login', $data);
        $response->assertStatus(401);
    }

    /**
     * @depends test_login
     */
    public function test_logout($token)
    {
        $data = [
            'token' => $token
        ];
        $response = $this->post('api/logout', $data);
        $response->assertStatus(200);
    }

    /**
     * @depends test_register
     */
    public function test_delete_user($data)
    {
        $userId = $data['id'];
        $response = $this->delete("api/users/$userId");
        $response->assertStatus(204);
    }
}