<?php

namespace App\Entities\Logs\Repositories\Interfaces;

use App\Entities\Payments\Payment;
use App\Entities\Payments\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Database\QueryException;

class PaymentRepository implements PaymentRepositoryInterface{
    private $columns = ['id', 'total_customer', 'purchase_customer'];

    public function __construct(Payment $payment)
    {
        $this->model = $payment;
    }

    public function listPayments()
    {
        try {
            return  $this->model
                ->get($this->columns);
        } catch (QueryException $e) {
            abort(503, $e->getMessage());
        }
    }

    public function createPayment(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            abort(503, $e->getMessage());
        }
    }
}
