<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;

final class UserAddressTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_add_address()
    {
        $user = factory(\App\User::class)->create();
        $address = factory(\App\UserAddress::class)->make();
        $userId = $user->id;
        $response = $this->actingAs($user, 'api')->post
            ("api/users/$userId/addresses", ['address' => $address->toArray()]);
        $response->assertStatus(201);
    }

    public function test_get_address()
    {
        $user = factory(\App\User::class)->create();
        $address = factory(\App\UserAddress::class)->make();
        $userId = $user->id;
        $this->actingAs($user, 'api')->post
            ("api/users/$userId/addresses", ['address' => $address->toArray()]);
        $response = $this->actingAs($user, 'api')->get("api/users/$userId/addresses");
        $response->assertStatus(200);
    }

    public function test_delete_address()
    {
        $user = factory(\App\User::class)->create();
        $address = factory(\App\UserAddress::class)->make();
        $userId = $user->id;
        $this->actingAs($user, 'api')->post
            ("api/users/$userId/addresses", ['address' => $address->toArray()]);
        $response = $this->actingAs($user, 'api')->get("api/users/$userId/addresses");
        $data = json_decode($response->getContent(), true);
        $response = $this->actingAs($user, 'api')->delete
            ("api/users/$userId/addresses", ['addressId' => $data[0]['id']]);
        $response->assertStatus(204);
    }


    // public function tearDown(): void
    // {
    //     $this->user->remove();
    // }

}