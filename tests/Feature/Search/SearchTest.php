<?php
namespace Tests\Feature;

use App\Product;
use App\Inventory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class SearchTest extends TestCase
{
    use DatabaseTransactions;

    public function test_search()
    {
        $product = Product::factory()
            ->create(['title' => 'Perrier']);
        $inventory = Inventory::factory()->create(['product_id' => $product->id]);
        sleep(5);
        $q = 'Per';
        $index = 'inventory';
        $storeId = $inventory->store_id;
        $response = $this->get("api/search?index=$index&q=$q&store_id=$storeId");
        $content = json_decode($response->getContent(), true);
        $this->assertNotEmpty($content['hits']);
        $response->assertStatus(200);
    }
}