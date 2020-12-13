<?php

namespace App\Factories;

use App\Stripe;

class CreditCardFactory 
{
    public static function init($service = 'stripe')
    {
        switch ($service)
        {
            case 'stripe':
                $card = new Stripe();
                break;
        }
        return $card;
    }
}