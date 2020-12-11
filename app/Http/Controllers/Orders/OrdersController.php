<?php

namespace App\Http\Controllers\Orders;

use App\Order;
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
            'total' => 'required|numeric|between:0,99.99',
            'total_tax' => 'required|numeric|between:0,99.99'
        ]); 

        $order = Order::create([
            'user_id' => $data['user_id'],
            'total' => $data['total'],
            'total_tax' => $data['total_tax']
        ]);

        return new Response($order->id, 201);
    }

    protected function update(Request $request, Order $order): Response
    {
        $data = $request->validate([
            'status' => 'required'
        ]); 

        Order::where('id', $order->id)->update(['status' => $data['status']]);
        $order = Order::findOrFail($order->id);
        
        return new Response($order->toArray(), 200);
    }

    protected function destroy(Request $request, Order $order): Response
    {
        $order->delete();

        return new Response([], 204);
    }
}