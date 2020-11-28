<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    // use RefreshDatabase;

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

    /**
     * @depends test_register
     */
    public function test_activate_user($data)
    {
        $userId = $data['id'];
        $response = $this->patch("api/users/$userId/activate", $data);
        $response->assertStatus(200);
    }

    /**
     * @depends test_register
     */
    public function test_activate_user_with_wrong_code($data)
    {
        $userId = $data['id'];
        $data['token'] = 9999;
        $response = $this->patch("api/users/$userId/activate", $data);
        $response->assertStatus(500);
    }

    public function test_register_existing_user()
    {
        $data = [
            'name' => 'Mert Metin',
            'phone' => '(613) 327-8306',
            'email' => 'mertmetin@outlook.com',
            'password' => '2631'
        ];

        $response = $this->post('api/users', $data);
        $response->assertStatus(500);
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

    public function test_register_with_bad_name()
    {
        $data = [
            // Test this to check if the user inputs with a name and surname with a space
            'name' => '',
            'phone' => '(613) 327-8306',
            'email' => 'mertmetin@outlook.com',
            'password' => '2631'
        ];

        $response = $this->post("api/users/", $data);
        $response->assertStatus(500);
    }

    public function test_register_with_bad_phone_number()
    {
        $data = [
            // Test this to check if the user inputs with a name and surname with a space
            'name' => 'mert',
            'phone' => '6133278306',
            'email' => 'mertmetin@outlook.com',
            'password' => '2631'
        ];

        $response = $this->post("api/users/", $data);
        $response->assertStatus(500);
    }

    public function test_register_with_bad_email()
    {
        $data = [
            // Test this to check if the user inputs with a name and surname with a space
            'name' => 'mert',
            'phone' => '(613) 327-8306',
            'email' => 'myemail',
            'password' => '2631'
        ];

        $response = $this->post("api/users/", $data);
        $response->assertStatus(500);
    }


    public function test_register_with_bad_password()
    {
        $data = [
            // Test this to check if the user inputs with a name and surname with a space
            'name' => 'mert',
            'phone' => '(613) 327-8306',
            'email' => 'mertmetin@outlook.com',
            // The password must be min 4 chars length
            'password' => '26'
        ];

        $response = $this->post("api/users/", $data);
        $response->assertStatus(500);
    }
}
