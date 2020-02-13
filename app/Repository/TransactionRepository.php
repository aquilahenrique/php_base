<?php


namespace App\Repository;

use App\Service\PaymentAuthorization;
use App\Transaction;
use Carbon\Carbon;

class TransactionRepository
{
    /**
     * @var PaymentAuthorization
     */
    protected $authorization;

    /**
     * TransactionRepository constructor.
     * @param PaymentAuthorization $authorization
     */
    public function __construct(PaymentAuthorization $authorization)
    {
        $this->authorization = $authorization;
    }

    public function save(array $data) :Transaction
    {
        if ($this->authorization->allow((float) $data['value'])) {
            $data['transaction_date'] = Carbon::now();
            return Transaction::create($data);
        }
        throw new \DomainException('Transaction not allowed');
    }

    public function find(int $id) :?Transaction
    {
        return Transaction::find($id);
    }
}