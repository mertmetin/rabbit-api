<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Store;
use App\Product;
use App\Inventory;
use App\ProductCategory;
use Database\Seeders\InventorySeeder;

final class InventoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_categories()
    {
        $this->seed(InventorySeeder::class);
        $store = Store::first();
        $storeId = $store->id;
        $response = $this->get("api/lists/products?store_id=$storeId");
        $content = $response->getContent();
        $this->assertNotNull($content);
        $response->assertStatus(200); 
    }

    public function test_get_inventories()
    {
        $this->seed(InventorySeeder::class);
        $response = $this->get("api/inventory");
        $content = $response->getContent();
        $this->assertNotNull($content);
        $response->assertStatus(200); 
    }

    public function test_get_store_inventory()
    {
        $this->seed(InventorySeeder::class);
        $store = Store::first();
        $storeId = $store->id;
        $response = $this->get("api/inventory?store=$storeId");
        $content = json_decode($response->getContent());
        $this->assertEquals($content[0]->store_id, $storeId);
        $response->assertStatus(200); 
    }

    public function test_add_store_inventory()
    {
        $data = Inventory::factory()->make();
        $response = $this->post("api/inventory", $data->toArray());
        $response->assertStatus(201); 
    }

    public function test_update_store_inventory()
    {
        $inventory = Inventory::factory()->create();
        $inventoryId = $inventory->id;
        $response = $this->put("api/inventory/$inventoryId", ['quantity' => 100]);
        $content = json_decode($response->getContent());
        $this->assertEquals(100, $content->quantity);
        $response->assertStatus(200); 
    }

    public function test_delete_store_inventory()
    {
        $data = Inventory::factory()->make();
        $response = $this->post("api/inventory", $data->toArray());
        $inventoryId = $response->getContent();
        $response = $this->delete("api/inventory/$inventoryId");
        $response->assertStatus(204); 
    }
}