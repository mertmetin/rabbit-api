<?php
namespace Tests\Feature;

use App\User;
use App\Inventory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class UsersTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_auth_user(): void
    {
        $user = User::factory()->create();
        $data = [
            'phone' => $user->phone,
            'password' => 2631
        ];
        $this->post('api/login', $data);
        $authUser = $this->actingAs($user, 'api')->get('api/user');
        $this->assertEquals($user['id'], $authUser['id']);
    }

    public function test_edit_user(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;
        $data = [
            'name' => 'Mert Metin',
            'phone' => '(613) 327-8306',
            'email' => 'mertmetin@outlook.com'
        ];
        $result = $this->actingAs($user, 'api')
            ->put("api/users/$userId", $data);
        $content = json_decode($result->getContent(), true);
        $this->assertEquals($data['name'], $content['name']);
        $this->assertEquals($data['email'], $content['email']);
        $this->assertEquals($data['phone'], $content['phone']);
    }

    public function test_user_password_change(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;
        $data = [
            'oldPassword' => 2631,
            'password' => 2635
        ];
        $response = $this->actingAs($user, 'api')
            ->patch("api/users/$userId/password/change", $data);
        $response->assertStatus(200);
    }
}

