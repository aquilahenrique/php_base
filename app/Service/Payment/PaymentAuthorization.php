<?php


namespace App\Service;


use App\Service\Payment\AuthorizationInterface;
use App\Transaction;

class PaymentAuthorization implements AuthorizationInterface
{
    const MAX_VALUE = 100;

    public function allow(float $value) :bool
    {
        return $value < self::MAX_VALUE && $value > 0;
    }
}