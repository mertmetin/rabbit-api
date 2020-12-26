<?php
namespace Tests\Feature;

use App\Promotion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class PromotionsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_promotions()
    {
        $promotion = Promotion::factory()->create();
        $response = $this->get('api/promotions');
        $data = json_decode($response->getContent(), true);
        $response->assertStatus(200);
        $this->assertArrayHasKey('title', $data[0]);
    }
}