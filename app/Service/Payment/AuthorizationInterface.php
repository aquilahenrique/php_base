<?php


namespace App\Service\Payment;


use App\Transaction;

interface AuthorizationInterface
{
    public function allow(float $value) :bool ;
}