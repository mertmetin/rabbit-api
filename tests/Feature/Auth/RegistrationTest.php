<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_register(): void
    {
        $user = User::factory()->make();
        $response = $this->post('api/users', $user->toArray());
        $response->assertStatus(201);
    }

    public function test_activate_user(): void
    {
        $user = User::factory()->make();
        $response = $this->post('api/users', $user->toArray());
        $data = json_decode($response->getContent(), true);
        $userId = $data['id'];
        $response = $this->patch("api/users/$userId/activate", $data);
        $response->assertStatus(200);
    }

    public function test_activate_user_with_wrong_code(): void
    {
        $user = User::factory()->make();
        $response = $this->post('api/users', $user->toArray());
        $data = json_decode($response->getContent(), true);
        $userId = $data['id'];
        $data['token'] = 9999;
        $response = $this->patch("api/users/$userId/activate", $data);
        $response->assertStatus(500);
    }

    public function test_register_existing_user(): void
    {
        $user = User::factory()->create();
        $response = $this->post('api/users', $user->make()->toArray());
        $response->assertStatus(500);
    }

    public function test_delete_user(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;
        $response = $this->delete("api/users/$userId");
        $response->assertStatus(204);
    }

    public function test_register_with_bad_name(): void
    {
        $user = User::factory()->make();
        $user->name = '';
        $response = $this->post("api/users/", $user->toArray());
        $response->assertStatus(500);
    }

    public function test_register_with_bad_phone_number(): void
    {
        $user = User::factory()->make();
        $user->phone = '';
        $response = $this->post("api/users/", $user->toArray());
        $response->assertStatus(500);
    }

    public function test_register_with_bad_email(): void
    {
        $user = User::factory()->make();
        $user->email = '';
        $response = $this->post("api/users/", $user->toArray());
        $response->assertStatus(500);
    }


    public function test_register_with_bad_password(): void
    {
        $user = User::factory()->make();
        $user->password = '';
        $response = $this->post("api/users/", $user->toArray());
        $response->assertStatus(500);
    }
}
