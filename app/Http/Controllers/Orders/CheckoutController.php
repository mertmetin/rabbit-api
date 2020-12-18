<?php

namespace App\Http\Controllers\Orders;

use App\User;
use App\Store;
use App\Product;
use App\Checkout;
use App\Inventory;
use App\UserAddress;
use App\TaxCalculator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\PaymentMethodsRepository;

class CheckoutController extends Controller
{
    protected function store(Request $request): Response
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'store_id' => 'required|integer',
            'payment_method_id' => 'required|integer',
            'user_address_id' => 'required|integer',
            'line_items' => 'required'
        ]); 

        try {
            $user = User::findOrFail($data['user_id']);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception('User not found.');
        }

        if ($request->user()->cannot('create', Checkout::class))
            abort(403);

        try {
            Store::findOrFail($data['store_id']);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception('Store not found.');
        }

        try {
            $userAddress = UserAddress::findOrFail($data['user_address_id']);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception('User address not found.');
        }

        $total = 0;
        $totalTax = 0.0;
        $lineItems = $data['line_items'];
        $postalCode = $userAddress->postal_code;
        $calculator = new TaxCalculator();

        foreach ($lineItems as $key => $lineItem)
        {
            try {
                $product = Product::findOrFail($lineItem['id']);
            } catch (ModelNotFoundException $exception) {
                $order->delete();
                throw new \Exception('Product not found.');
            }

            $total += $product->price * $lineItem['quantity'];

            if ($product->taxable)
                $totalTax += $calculator->calculateTax($postalCode, $product->price) 
                    * $lineItem['quantity'];
        }

        $checkout = Checkout::create([
            'user_id' => $data['user_id'],
            'store_id' => $data['store_id'],
            'payment_method_id' => $data['payment_method_id'],
            'user_address_id' => $data['user_address_id'],
            'total' => $total,
            'total_tax' => $totalTax,
        ]);

        return new Response([$checkout->toArray()], 201);
    }
}