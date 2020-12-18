<?php

namespace App\Http\Controllers\Payment;

use App\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\PaymentMethodsRepository;

class PaymentMethodsController extends Controller
{
    /**
     * The payment methods repository implementation.
     *
     * @var PaymentMethodsRepository
     */
    protected $paymentMethods;

    public function __construct(PaymentMethodsRepository $paymentMethods)
    {
        $this->paymentMethods = $paymentMethods;
    }

    protected function get(Request $request, PaymentMethod $paymentMethod): Response
    {
        $this->authorize('update', $paymentMethod);

        $res = $this->paymentMethods->getPaymentMethod($paymentMethod->toArray());

        return new Response($res, 200);
    }

    protected function store(Request $request): Response
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'type' => 'required|string',
            'card' => 'required'
        ]); 

        $result = $this->paymentMethods->store($data);

        return new Response($result, 201);
    }

    protected function update(Request $request, PaymentMethod $paymentMethod): Response
    {
        $this->authorize('update', $paymentMethod);

        $data = $request->validate([
            'exp_month' => 'integer',
            'exp_year' => 'integer'
        ]); 

        $paymentMethod->card = [
            'exp_month' => $data['exp_month'],
            'exp_year' => $data['exp_year']
        ];

        $res = $this->paymentMethods->update($paymentMethod->toArray());

        return new Response($res, 200);
    }

    protected function delete(Request $request, PaymentMethod $paymentMethod): Response
    {
        $this->authorize('update', $paymentMethod);

        $res = $this->paymentMethods->deletePaymentMethod($paymentMethod->toArray());

        return new Response($res, 204);
    }
}
