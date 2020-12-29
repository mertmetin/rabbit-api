<?php
namespace Tests\Feature;

use App\User;
use App\Store;
use Tests\TestCase;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class StoreTest extends TestCase
{
    use DatabaseTransactions;

    public function test_add_store()
    {
        $user = User::factory()->create();
        $store = Store::factory()->make();
        $response = $this->actingAs($user, 'api')
            ->post('api/stores', $store->toArray());
        $response->assertStatus(201);
    }

    public function test_get_store()
    {
        $user = User::factory()->create();
        $stores = Store::factory()->make();
        $this->actingAs($user, 'api')->post('api/stores', $stores->toArray());
        $response = $this->actingAs($user, 'api')->get('api/stores');
        $data = json_decode($response->getContent(), true);
        $this->assertNotNull($data[0]);
        $response->assertStatus(200);
    }

    public function test_get_store_closest_store()
    {
        $user = User::factory()->create();
        $store1 = Store::factory()->create(
            [
                'name' => 'Ottawa1',
                'coordinates' => new Point(45.4409817, -75.6310358)
            ]
        );
        $store2 = Store::factory()->create(
            [
                'name' => 'Ottawa2',
                'coordinates' => new Point(46.4409817, -75.6310358)
            ]
        );
        $address = [
            'lat' => '46.4142038',
            'lng' => '-75.637007'
        ];

        $q = http_build_query($address);
        $response = $this->actingAs($user, 'api')->get("api/stores/closest?$q");
        $data = json_decode($response->getContent(), true);
        $this->assertNotNull($data);
        $this->assertEquals($data['name'], 'Ottawa2');
    }

    public function test_get_no_store()
    {
        $user = User::factory()->create();
        $store1 = Store::factory()->create(
            [
                'name' => 'Ottawa1',
                'coordinates' => new Point(45.4409817, -75.6310358)
            ]
        );
        $store2 = Store::factory()->create(
            [
                'name' => 'Ottawa2',
                'coordinates' => new Point(46.4409817, -75.6310358)
            ]
        );
        $address = [
            'lat' => '50.4142038',
            'lng' => '-75.637007'
        ];

        $q = http_build_query($address);
        $response = $this->actingAs($user, 'api')->get("api/stores/closest?$q");
        $data = json_decode($response->getContent(), true);
        $this->assertNull($data);
    }
}