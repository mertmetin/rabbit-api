<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Grimzy\LaravelMysqlSpatial\Types\Point;

final class CustomerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_add_customer()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user, 'api')->
            post('api/payment/customers', ['userId' => $user->id]);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('customer_id', $data);
        $response->assertStatus(201);
    }
}