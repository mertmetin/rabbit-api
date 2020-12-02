<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Grimzy\LaravelMysqlSpatial\Types\Point;

final class CardsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_add_card()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user, 'api')->
            post('api/payment/customers', ['userId' => $user->id]);
        $data = json_decode($response->getContent(), true);
        $customerId = $data['customer_id'];
        $cardInfo = [
            'cardNumber' => '4242424242424242',
            'cvc' => '333',
            'expiryDate' => '09/28'
        ];
        $response = $this->actingAs($user, 'api')->
            post('api/payment/cards', ['customerId' => $customerId, 'card_info' => $cardInfo]);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('card_id', $data);
        $response->assertStatus(201); 
    }

    public function test_get_card()
    {
        $user = factory(\App\User::class)->create();
        $userId = $user->id;
        $response = $this->actingAs($user, 'api')->
            post('api/payment/customers', ['userId' => $userId]);
        $data = json_decode($response->getContent(), true);
        $customerId = $data['customer_id'];
        $cardInfo = [
            'cardNumber' => '4242424242424242',
            'cvc' => '333',
            'expiryDate' => '09/28'
        ];
        $this->actingAs($user, 'api')->
            post('api/payment/cards', ['customerId' => $customerId, 'card_info' => $cardInfo]);
        $response = $this->actingAs($user, 'api')->
            get("api/payment/cards?userId=$userId");
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($data[0]['last4'], 4242);
        $response->assertStatus(200); 
    }

    public function test_update_card()
    {
        $user = factory(\App\User::class)->create();
        $userId = $user->id;
        $response = $this->actingAs($user, 'api')->
            post('api/payment/customers', ['userId' => $userId]);
        $data = json_decode($response->getContent(), true);
        $customerId = $data['customer_id'];
        $cardInfo = [
            'cardNumber' => '4242424242424242',
            'cvc' => '333',
            'expiryDate' => '09/28'
        ];
        $response = $this->actingAs($user, 'api')->
            post('api/payment/cards', ['customerId' => $customerId, 'card_info' => $cardInfo]);
        $data = json_decode($response->getContent(), true);

        $paymentMethod = [
            'customer_id' => $customerId,
            'id' => $data['card_id'],
            'exp_month' => '10',
            'exp_year' => '26'
        ];
        $response = $this->actingAs($user, 'api')->
            patch("api/payment/cards", ['paymentMethod' => $paymentMethod]);
        $data = json_decode($response->getContent(), true);
        $response->assertStatus(204); 
    }

    public function test_delete_card()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user, 'api')->
            post('api/payment/customers', ['userId' => $user->id]);
        $data = json_decode($response->getContent(), true);
        $customerId = $data['customer_id'];
        $cardInfo = [
            'cardNumber' => '4242424242424242',
            'cvc' => '333',
            'expiryDate' => '09/28'
        ];
        $response = $this->actingAs($user, 'api')->
            post('api/payment/cards', ['customerId' => $customerId, 'card_info' => $cardInfo]);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('card_id', $data);
        $response->assertStatus(201);
        $cardId = $data['card_id'];
        $paymentInfo = [
            'customer_id' => $customerId,
            'id' => $cardId
        ];
        $response = $this->actingAs($user, 'api')->
            delete('api/payment/cards', ['paymentMethod' => $paymentInfo]);
        $response->assertStatus(204);  
    }
}