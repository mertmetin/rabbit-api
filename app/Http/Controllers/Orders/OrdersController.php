<?php

namespace App\Http\Controllers\Orders;

use App\Order;
use App\OrderItems;
use App\User;
use App\Product;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    protected function get(Request $request): Response
    {
        return new Response(Order::all());
    }

    protected function getOrder(Request $request, Order $order): Response
    {
        return new Response(Order::where('id', $order->id)->get()->first());
    }

    protected function store(Request $request): Response
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'store_id' => 'required|integer',
            'total' => 'required|numeric|between:0,99.99',
            'total_tax' => 'required|numeric|between:0,99.99',
            'line_items' => 'required'
        ]); 

        try {
            User::findOrFail($data['user_id']);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception('User not found.');
        }

        try {
            Store::findOrFail($data['store_id']);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception('Store not found.');
        }


        $order = Order::create([
            'user_id' => $data['user_id'],
            'store_id' => $data['store_id'],
            'total' => $data['total'],
            'total_tax' => $data['total_tax']
        ]);

        $lineItems = $data['line_items'];

        foreach ($lineItems as $lineItem)
        {
            try {
                Product::findOrFail($lineItem['id']);
            } catch (ModelNotFoundException $exception) {
                $order->delete();
                throw new \Exception('Product not found.');
            }

            $item = OrderItems::create(
                [
                    'product_id' => $lineItem['id'], 
                    'quantity' => $lineItem['quantity']
                ]
            );
        }

        return new Response(['order_id' => $order->id], 201);
    }

    protected function closeOrder(Request $request, Order $order): Response
    {
        Order::where('id', $order->id)->update(['status' => 'closed']);
        $order = Order::findOrFail($order->id);
        
        return new Response($order->toArray(), 200);
    }


    protected function cancelOrder(Request $request, Order $order): Response
    {
        Order::where('id', $order->id)->update(['status' => 'cancelled']);
        $order = Order::findOrFail($order->id);
        
        return new Response($order->toArray(), 200);
    }

    protected function destroy(Request $request, Order $order): Response
    {
        $order->delete();

        return new Response([], 204);
    }
}