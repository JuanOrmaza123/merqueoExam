<?php

namespace App\Entities\Payments\Repositories\Interfaces;

interface PaymentRepositoryInterface{
    public function listPayments();

    public function createPayment(array $data);
}
