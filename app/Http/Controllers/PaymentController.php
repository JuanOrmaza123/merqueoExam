<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Services\Interfaces\PaymentServiceInterface;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function createPayment(CreatePaymentRequest $createPaymentRequest){
        $response = $this->paymentService->createPayment($createPaymentRequest->validated());
        dd($response);
    }
}
