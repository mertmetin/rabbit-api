<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class StoreTest extends TestCase
{
    use DatabaseTransactions;

    public function test_add_store()
    {
        $user = factory(\App\User::class)->create();
        $store = factory(\App\Store::class)->make();
        $response = $this->actingAs($user, 'api')->post('api/stores', $store->toArray()[0]);
        $response->assertStatus(201);
    }

    public function test_get_store()
    {
        $user = factory(\App\User::class)->create();
        $stores = factory(\App\Store::class)->make();
        $this->actingAs($user, 'api')->post('api/stores', $stores->toArray()[0]);
        $response = $this->actingAs($user, 'api')->get('api/stores');
        $data = json_decode($response->getContent(), true);
        $this->assertNotNull($data[0]);
        $response->assertStatus(200);
    }

    public function test_get_store_ottawa_east()
    {
        $user = factory(\App\User::class)->create();
        $stores = factory(\App\Store::class)->make();
        $this->actingAs($user, 'api')->post('api/stores', $stores->toArray()[0]); 
        $this->actingAs($user, 'api')->post('api/stores', $stores->toArray()[1]); 
        $address = [
            'lat' => '45.4142038',
            'lng' => '-75.637007'
        ];
        $q = http_build_query($address);
        $response = $this->actingAs($user, 'api')->get("api/stores/closest?$q");
        $data = json_decode($response->getContent(), true);
        $this->assertNotNull($data);
        $this->assertEquals($data['name'], 'Ottawa East');
    }

    public function test_get_store_ottawa_center()
    {
        $user = factory(\App\User::class)->create();
        $stores = factory(\App\Store::class)->make();
        $this->actingAs($user, 'api')->post('api/stores', $stores->toArray()[0]); 
        $this->actingAs($user, 'api')->post('api/stores', $stores->toArray()[1]); 
        $address = [
            'lat' => '45.4347113',
            'lng' => '-75.7352354'
        ];
        $q = http_build_query($address);
        $response = $this->actingAs($user, 'api')->get("api/stores/closest?$q");
        $data = json_decode($response->getContent(), true);
        $this->assertNotNull($data);
        $this->assertEquals($data['name'], 'Ottawa Center');
    }

    public function test_get_store_find_fail()
    {
        $user = factory(\App\User::class)->create();
        $stores = factory(\App\Store::class)->make();
        $this->actingAs($user, 'api')->post('api/stores', $stores->toArray()[0]); 
        $this->actingAs($user, 'api')->post('api/stores', $stores->toArray()[1]); 
        // Bayshore
        $address = [
            'lat' => '45.3431272',
            'lng' => '-75.8458969'
        ];
        $q = http_build_query($address);
        $response = $this->actingAs($user, 'api')->get("api/stores/closest?$q");
        $data = json_decode($response->getContent(), true);
        $this->assertNull($data);
    }
}