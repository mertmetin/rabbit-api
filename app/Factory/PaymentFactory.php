<?php

namespace App\Factories;

use App\PaymentMethod;

class PaymentFactory 
{
    protected $payment;

    public static function init($type)
    {
        $factory = new PaymentFactory();

        switch ($type)
        {
            case 'card':
                $payment = CreditCardFactory::init();
                break;
        }

        $factory->payment = $payment;

        return $factory;
    }

    public function store($data)
    {
        $paymentMethod = PaymentMethod::create($data);
        $id = $paymentMethod->id;

        try {   
            $res = $this->payment->store($id, $data);
        } catch (Exception $e) {
            $paymentMethod->delete();
        }

        return $id;
    }

    public function get($id)
    {
        return $this->payment->get($id);
    }
    
    public function update($data)
    {
        return $this->payment->update($data);
    }

    public function delete($data)
    {
        return $this->payment->delete($data);
    }

    public function charge($data, $total)
    {
        $this->payment->charge($data, $total);
    }
}