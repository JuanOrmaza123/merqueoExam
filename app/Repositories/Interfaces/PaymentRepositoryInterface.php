<?php

namespace App\Repositories\Interfaces;

use App\Models\Payment;

/**
 * Interface PaymentRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface PaymentRepositoryInterface
{

    /**
     * @param array $data
     * @return Payment
     */
    public function createPayment(array $data): Payment;
}
