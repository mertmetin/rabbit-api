<?php
namespace Tests\Feature;

use App\User;
use App\PaymentMethod;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

final class PaymentMethodsTest extends TestCase
{
    use DatabaseTransactions;

    function test_add_credit_card()
    {
        $user = User::factory()->create();
        $paymentMethod =  PaymentMethod::factory()
            ->make(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->
            post('api/payment/methods', $paymentMethod->toArray());
        $response->assertStatus(201);        
    }

    function test_get_credit_card()
    {
        $user = User::factory()->create();
        $paymentMethod =  PaymentMethod::factory()
            ->make(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->
            post('api/payment/methods', $paymentMethod->toArray());
        $paymentMethodId = $response->getContent();
        $response = $this->actingAs($user, 'api')->
            get("api/payment/methods/$paymentMethodId", $paymentMethod->toArray());
        $response->assertStatus(200);        
    }

    function test_delete_credit_card()
    {
        $user = User::factory()->create();
        $paymentMethod =  PaymentMethod::factory()
            ->make(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->
            post('api/payment/methods', $paymentMethod->toArray());
        $paymentMethodId = $response->getContent();
        $response = $this->actingAs($user, 'api')->
            delete("api/payment/methods/$paymentMethodId");
        $response->assertStatus(204);        
    }

    function test_update_credit_card()
    {
        $user = User::factory()->create();
        $paymentMethod =  PaymentMethod::factory()
            ->make(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->
            post('api/payment/methods', $paymentMethod->toArray());
        $paymentMethodId = $response->getContent();
        $card  =  [
            'exp_month' => 06,
            'exp_year' => 2023
        ];
        $response = $this->actingAs($user, 'api')
            ->put("api/payment/methods/$paymentMethodId", $card);
        $paymentMethod = json_decode($response->getContent(), true);
        $this->assertEquals($paymentMethod['card']['exp_month'],  $card['exp_month']);
        $this->assertEquals($paymentMethod['card']['exp_year'],  $card['exp_year']);
        $response->assertStatus(200);        
    }
}