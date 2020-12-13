<?php

namespace App;

use App\StripeCustomer;
use App\StripeCard;

class Stripe
{
    function __construct()
    {
        \Stripe\Stripe::setApiKey('***REMOVED***');
    }

    public function store($id, $data)
    {
        $customer = StripeCustomer::where('user_id', $data['user_id'])->get()->last();
        $customerId = (empty($customer)) ? 
            $this->createCustomer($data) : $customer->customer_id;
        $card = $data['card'];

        $token = \Stripe\Token::create([
            'card' => [
                'number' => $card['number'],
                'exp_month' => $card['exp_month'],
                'exp_year' => $card['exp_year'],
                'cvc' => $card['cvc'],
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
            'payment_methods_id' => $id,
            'customer_id' => $customerId,
            'fingerprint' => $card->fingerprint,
            'last4' => $card->last4,
            'exp_month' => $card->exp_month,
            'exp_year' => $card->exp_year,
            'brand' => $card->brand,
        ]);

        return $card->id;
    }

    public function get($id)
    {   
        return StripeCard::where('payment_methods_id', $id)->get()->last();
    }

    public function update($data)
    {   
        $card = StripeCard::where('payment_methods_id', $data['id'])->get()->last();
                
        try {
            $result = \Stripe\Customer::updateSource(
                $card->customer_id,
                $card->id,
                [
                    'exp_month' => $data['card']['exp_month'],
                    'exp_year' => $data['card']['exp_year']
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception('Unable to update card in Stripe');
        }

        $card->exp_month = $data['card']['exp_month'];
        $card->exp_year = $data['card']['exp_year'];
        $card->update();

        return StripeCard::where('id', $card->id)->get()->last();
    }

    public function delete($data)
    {   
        $card = StripeCard::where('payment_methods_id', $data['id'])->get()->last();
        $card->user_id = $card->customer->user_id;
        
        try {
            $result = \Stripe\Customer::deleteSource(
                $card->customer_id,
                $card->id
            );
        } catch (\Exception $e) {
            throw new \Exception('Unable to delete card from Stripe');
        }

        return $card->delete();
    }

    public function createCustomer($data)
    {
        $user = User::findOrFail($data['user_id']);

        $customer = \Stripe\Customer::create([
            'email' => $user->email,
            'phone' => $user->phone
        ]);

        // Put a copy to the DB
        $customer = StripeCustomer::create([
            'user_id' => $user->id,
            'customer_id' => $customer->id
        ]);


        return $customer->customer_id;
    }
}