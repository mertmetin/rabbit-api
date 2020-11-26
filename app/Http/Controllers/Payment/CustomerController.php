<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\StripeCustomer;

class CustomerController extends Controller
{
    protected function register(Request $request)
    {
        $userId = $request->input('userId');

        if (!$userId)
            throw new \Exception('Invalid request.');

        try {
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception('User not found.');
        }

        $customer = StripeCustomer::where('user_id', $userId)->get()->last();

        if ($customer)
            throw new Exception('Customer already exists.');

        // Set the Stripe API key
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = \Stripe\Customer::create([
            'email' => $user->email,
            'phone' => $user->phone
        ]);

        $customerId = $customer->id;

        // Put a copy to the DB
        StripeCustomer::create([
            'user_id' => $userId,
            'customer_id' => $customerId
        ]);

        return $customerId;
    }
}
