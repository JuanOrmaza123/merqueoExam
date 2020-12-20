<?php

namespace App\Services;

use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Services\Interfaces\PaymentServiceInterface;

class PaymentService implements PaymentServiceInterface
{
    protected $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function createPayment(array $data): array
    {
        return [];
    }
}
