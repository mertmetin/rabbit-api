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
        $response = $this->actingAs($user, 'api')->post('api/stores', $store->toArray());
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

    // public function test_get_store_ottawa_east()
    // {
    //     $user = User::factory()->create();
    //     $store = Store::factory()->make();
    //     $ottawaEast = [
    //         'name' => 'Ottawa East',
    //         'coordinates' => new Point(45.4409817, -75.6310358)
    //     ];
    //     $store = Store::factory()->make($ottawaEast);
    //     $address = [
    //         'lat' => '45.4142038',
    //         'lng' => '-75.637007'
    //     ];
    //     $q = http_build_query($address);
    //     $response = $this->actingAs($user, 'api')->get("api/stores/closest?$q");
    //     $data = json_decode($response->getContent(), true);
    //     $this->assertNotNull($data);
    //     $this->assertEquals($data['name'], 'Ottawa East');
    // }

    // public function test_get_store_ottawa_center()
    // {
    //     $user = User::factory()->create();
    //     $store = Store::factory()->make();
    //     $ottawaEast = [
    //         'name' => 'Ottawa East',
    //         'coordinates' => new Point(45.4409817, -75.6310358)
    //     ];
    //     $store = Store::factory()->make($ottawaEast);
    //     $address = [
    //         'lat' => '45.4347113',
    //         'lng' => '-75.7352354'
    //     ];
    //     $q = http_build_query($address);
    //     $response = $this->actingAs($user, 'api')->get("api/stores/closest?$q");
    //     $data = json_decode($response->getContent(), true);
    //     dd($data);
    //     $this->assertNotNull($data);
    //     $this->assertEquals($data['name'], 'Ottawa Center');
    // }

    // public function test_get_store_find_fail()
    // {
    //     $user = User::factory()->create();
    //     $store = Store::factory()->make();
    //     // Bayshore
    //     $address = [
    //         'lat' => '45.3431272',
    //         'lng' => '-75.8458969'
    //     ];
    //     $q = http_build_query($address);
    //     $response = $this->actingAs($user, 'api')->get("api/stores/closest?$q");
    //     $data = json_decode($response->getContent(), true);
    //     $this->assertNull($data);
    // }
}