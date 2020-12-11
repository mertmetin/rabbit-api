<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class InventoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_inventories()
    {
        $user = factory(\App\User::class)->create();
        $inventory = factory(\App\Inventory::class)->create();
        $response = $this->actingAs($user, 'api')
            ->get("api/inventory");
        $content = $response->getContent();
        $this->assertNotNull($content);
        $response->assertStatus(200); 
    }

    public function test_get_store_inventory()
    {
        $user = factory(\App\User::class)->create();
        $inventory = factory(\App\Inventory::class)->create();
        $storeId = $inventory->store_id;
        $response = $this->actingAs($user, 'api')
            ->get("api/inventory?store=$storeId");
        $content = json_decode($response->getContent());
        $this->assertEquals($content[0]->store_id, $storeId);
        $response->assertStatus(200); 
    }

    public function test_add_store_inventory()
    {
        $user = factory(\App\User::class)->create();
        $data = factory(\App\Inventory::class)->make();
        $response = $this->actingAs($user, 'api')
            ->post("api/inventory", $data->toArray());
        $response->assertStatus(201); 
    }

    public function test_update_store_inventory()
    {
        $user = factory(\App\User::class)->create();
        $data = factory(\App\Inventory::class)->make();
        $response = $this->actingAs($user, 'api')
            ->post("api/inventory", $data->toArray());
        $inventoryId = $response->getContent();
        $response = $this->actingAs($user, 'api')
            ->put("api/inventory/$inventoryId", ['quantity' => 100]);
        $content = json_decode($response->getContent());
        $this->assertEquals(100, $content->quantity);
        $response->assertStatus(200); 
    }

    public function test_delete_store_inventory()
    {
        $user = factory(\App\User::class)->create();
        $data = factory(\App\Inventory::class)->make();
        $response = $this->actingAs($user, 'api')
            ->post("api/inventory", $data->toArray());
        $inventoryId = $response->getContent();
        $response = $this->actingAs($user, 'api')
            ->delete("api/inventory/$inventoryId");
        $response->assertStatus(204); 
    }
}