<?php
namespace Tests\Feature;

use App\Inventory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class SearchTest extends TestCase
{
    use DatabaseTransactions;

    public function test_search()
    {
        $inventory =  Inventory::factory()->create();
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