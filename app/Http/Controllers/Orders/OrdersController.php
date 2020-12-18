<?php

namespace App\Http\Controllers\Orders;

use DB;
use App\Order;
use App\OrderItems;
use App\User;
use App\Product;
use App\Store;
use App\Checkout;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\TransactionRepository;
use App\Repositories\PaymentMethodsRepository;
// use App\PaymentMethod;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * The payment methods repository implementation.
     *
     * @var PaymentMethodsRepository
     */
    protected $paymentMethods;

    /**
     * The payment methods repository implementation.
     *
     * @var PaymentMethodsRepository
     */
    protected $transaction;

    public function __construct(PaymentMethodsRepository $paymentMethods, 
        TransactionRepository $transaction)
    {
        $this->transaction = $transaction;
        $this->paymentMethods = $paymentMethods;
    }

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
            'checkout_id' => 'required|integer',
            'line_items' => 'required'
        ]);

        try {
            $checkout = Checkout::findOrFail($data['checkout_id']);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception('Invalid order');
        }

        $order = Order::create([
            'user_id' => $checkout->user_id
        ]);

        $lineItems = $data['line_items'];

        foreach ($lineItems as $key => $lineItem)
        {
            try {
                $product = Product::findOrFail($lineItem['id']);
            } catch (ModelNotFoundException $exception) {
                $order->delete();
                throw new \Exception('Product not found.');
            }

            $lineItems[$key]['order_id'] = $order->id;
            $lineItems[$key]['product_id'] = $product->id;
            unset($lineItems[$key]['taxable']);
        }
        DB::table('order_items')->insert($lineItems);
        $paymentMethod = $this->paymentMethods->getById($checkout->payment_method_id);
        $paymentMethod = $this->paymentMethods->getPaymentMethod($paymentMethod);
        $total = (int) ($checkout->total + $checkout->total_tax) * 10;
        $this->transaction->store($paymentMethod, $total);

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