<?php

namespace App\Repositories;

use App\User;
use App\PaymentMethodTypes;use App\Factories\PaymentFactory;
use App\PaymentMethod;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
/**
 * Class PaymentMethodsRepository.
 */
class PaymentMethodsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return PaymentMethod::class;
    }

    public function store($data)
    {
         try {
            User::findOrFail($data['user_id']);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception('User not found.');
        }

        try {
            $paymentMethodType = PaymentMethodTypes::where('type', $data['type'])->get()->last();
        } catch (ModelNotFoundException $exception) {
            throw new \Exception("Invalid payment method: {$data['type']}");
        }

        $data['type_id'] = $paymentMethodType->id;
        $payment = PaymentFactory::init($data['type']);
    
        return $payment->store($data);
    }

    public function getPaymentMethod($data)
    {
        try {
            $paymentMethodType = PaymentMethodTypes::where('id', $data['type_id'])->get()->last();
            $type = $paymentMethodType['type'];
        } catch (ModelNotFoundException $exception) {
            throw new \Exception("Invalid payment method: $type");
        }

        $payment = PaymentFactory::init($type);
        $data[$type] = $payment->get($data['id']);

        return $data;
    }

    public function deletePaymentMethod($data)
    {
        try {
            $paymentMethodType = PaymentMethodTypes::where('id', $data['type_id'])->get()->last();
            $type = $paymentMethodType['type'];
        } catch (ModelNotFoundException $exception) {
            throw new \Exception("Invalid payment method: $type");
        }

        $payment = PaymentFactory::init($type);
        $res = $payment->delete($data);

        return $res;
    }

    public function update($data)
    {
        try {
            $paymentMethodType = PaymentMethodTypes::where('id', $data['type_id'])->get()->last();
            $type = $paymentMethodType['type'];
        } catch (ModelNotFoundException $exception) {
            throw new \Exception("Invalid payment method: $type");
        }

        $payment = PaymentFactory::init($type);
        $data[$type] = $payment->update($data);

        return $data;
    }
}
