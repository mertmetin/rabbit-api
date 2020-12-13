<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\StripeCard;
use App\StripeCustomer;

class CardController extends Controller
{

    protected function get(Request $request): Response
    {
        $userId = $request->input('userId');

        if (!$userId)
            throw new \Exception('Invalid request.');

        $stripeCustomer = StripeCustomer::where('user_id', $userId)->get()->last();
        $customerId = $stripeCustomer->customer_id;
        $stripeCards = StripeCard::where('customer_id', $customerId)->get();
        $lastCard = $stripeCards->last();
        $lastCard->user_id = $lastCard->customer->user_id;

        $this->authorize('view', $lastCard);

        return new Response($stripeCards->all());
    }

    protected function update(Request $request): Response
    {
        if (!$request->filled('paymentMethod'))
            throw new \Exception('Invalid request.');

        $paymentMethod = $request->input('paymentMethod');
        $customerId = $paymentMethod['customer_id'];
        $card = StripeCard::where('customer_id', $customerId)
                ->get()->last();
        $card->user_id = $card->customer->user_id;
        $this->authorize('update', $card);
        unset($card->user_id);

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $result = \Stripe\Customer::updateSource(
            $customerId,
            $paymentMethod['id'],
            [
                'exp_month' => $paymentMethod['exp_month'],
                'exp_year' => $paymentMethod['exp_year']
            ]
        );

        $card->update($paymentMethod);

        return new Response(null, 204);
    }

    protected function validateCreditCard($cardInfo)
    {
        if (empty($cardInfo['cardNumber']) || empty($cardInfo['cvc']) || empty($cardInfo['expiryDate']))
            throw new \Exception('Invalid card info');
    }

    protected function add(Request $request): Response
    {
        $customerId = $request->input('customerId');
        $cardInfo = $request->input('card_info');
      
        if (!$customerId || !$cardInfo)
            throw new \Exception('Invalid request.');
              
        // Validate credit card info (e.g. cvc, expiry date etc.)
        $this->validateCreditCard($cardInfo); 
        $customerId = $request->input('customerId');
        $cardNumber = str_replace(' ','', $cardInfo['cardNumber']);
        $cvc = $cardInfo['cvc'];
        list($expMonth, $expYear) = explode('/', $cardInfo['expiryDate']);

        // Set Stripe API key.
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $token = \Stripe\Token::create([
            'card' => [
                'number' => $cardNumber,
                'exp_month' => $expMonth,
                'exp_year' => $expYear,
                'cvc' => $cvc,
            ],
        ]);

        $cardToken = \Stripe\Token::retrieve($token->id);
        $cardFingerPrint = $cardToken->card->fingerprint;
        $card = StripeCard::where('fingerprint', $cardFingerPrint)->get()->last();

        if (!empty($card))
            throw new \Exception('This card is already in your wallet.');

         $card = \Stripe\Customer::createSource($customerId, [
            'source' => $token,
        ]);

        StripeCard::create([
            'id' => $card->id,
            'customer_id' => $customerId,
            'fingerprint' => $card->fingerprint,
            'last4' => $card->last4,
            'exp_month' => $card->exp_month,
            'exp_year' => $card->exp_year,
            'brand' => $card->brand,
        ]);

        return new Response(['card_id' => $card->id], 201);
    }

    protected function delete(Request $request): Response
    {
        if (!$request->filled('paymentMethod'))
            throw new \Exception('Invalid request.');

        $paymentMethod = $request->input('paymentMethod');
        $cardId = $paymentMethod['id'];
        $card = StripeCard::where('id', $cardId)->get()->last();
        $card->user_id = $card->customer->user_id;
        $this->authorize('delete', $card);

        if (!$card)
            throw new \Exception('This card is already deleted');

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $result = \Stripe\Customer::deleteSource(
            $paymentMethod['customer_id'],
            $cardId
        );
        
        return new Response(null, 204);
    }
}
