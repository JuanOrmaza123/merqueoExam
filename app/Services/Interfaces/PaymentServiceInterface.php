<?php


namespace App\Services\Interfaces;


interface PaymentServiceInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function createPayment(array $data): array;
}
