<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Transaction;
use App\Factory\PaymentMethodsRepository;
use App\Factory\PaymentFactory;

/**
 * Class TransactionRepository.
 */
class TransactionRepository extends BaseRepository
{
    public function __construct()
    {
        // $this->paymentMethods = $paymentMethods;
    }

    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Transaction::class;
    }

    public function store($data, $total)
    {
        $payment = PaymentFactory::init('card');
        return $payment->charge($data, $total);

        // dd($this->paymentMethods->getPaymentMethod($data));
    }
}
