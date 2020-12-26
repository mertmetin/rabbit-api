<?php
namespace Tests\Feature;


use App\User;
use App\UserAddress;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;

final class UserAddressTest extends TestCase
{
    use DatabaseTransactions;

    public function test_add_address()
    {
        $user = User::factory()->create();
        $address = UserAddress::factory()->make();
        $userId = $user->id;
        $response = $this->actingAs($user, 'api')->post
            ("api/users/$userId/addresses", ['address' => $address->toArray()]);
        $response->assertStatus(201);
    }

    public function test_get_address()
    {
        $user = User::factory()->create();
        $address = UserAddress::factory()->make();
        $userId = $user->id;
        $this->actingAs($user, 'api')->post
            ("api/users/$userId/addresses", ['address' => $address->toArray()]);
        $response = $this->actingAs($user, 'api')->get("api/users/$userId/addresses");
        $response->assertStatus(200);
    }

    public function test_delete_address()
    {
        $user = User::factory()->create();
        $address = UserAddress::factory()->make();
        $userId = $user->id;
        $this->actingAs($user, 'api')->post
            ("api/users/$userId/addresses", ['address' => $address->toArray()]);
        $response = $this->actingAs($user, 'api')->get("api/users/$userId/addresses");
        $data = json_decode($response->getContent(), true);
        $response = $this->actingAs($user, 'api')->delete
            ("api/users/$userId/addresses", ['addressId' => $data[0]['id']]);
        $response->assertStatus(204);
    }

    public function test_get_address_of_different_user()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $address = UserAddress::factory()->make();
        $userId = $user->id;
        $response = $this->actingAs($user, 'api')->post
            ("api/users/$userId/addresses", ['address' => $address->toArray()]);
        $response = $this->actingAs($user2, 'api')->get
            ("api/users/$userId/addresses", ['address' => $address->toArray()]);
        $response->assertStatus(403);
    }

    public function test_delete_address_of_different_user()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $address = UserAddress::factory()->make();
        $userId = $user->id;
        $response = $this->actingAs($user, 'api')->post
            ("api/users/$userId/addresses", ['address' => $address->toArray()]);
        $addressId = $response->getContent();
        $response = $this->actingAs($user2, 'api')->delete
            ("api/users/$userId/addresses", ['addressId' => $addressId]);
        $response->assertStatus(403);
    }
}