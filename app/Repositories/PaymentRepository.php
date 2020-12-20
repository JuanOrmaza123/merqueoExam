<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Database\QueryException;

/**
 * Class PaymentRepository
 * @package App\Repositories
 */
class PaymentRepository implements PaymentRepositoryInterface{

    /**
     * @var Payment
     */
    private $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * @param array|string[] $columns
     * @return array
     */
    public function listPayments(array $columns = ['*']): array
    {
        $paymentList = $this->payment->orderBy('value', 'desc')->orderBy('denomination', 'desc')->get($this->columns);

        return (empty($paymentList)) ? [] : $paymentList ;
    }

    /**
     * @param array $data
     * @return Payment
     */
    public function createPayment(array $data): Payment
    {
        return $this->payment->create($data);
    }
}
