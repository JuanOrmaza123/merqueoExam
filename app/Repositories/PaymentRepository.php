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
     * @param array $data
     * @return Payment
     */
    public function createPayment(array $data): Payment
    {
        return $this->payment->create($data);
    }
}
