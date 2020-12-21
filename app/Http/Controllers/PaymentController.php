<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaymentRequest;
use App\Services\Interfaces\PaymentServiceInterface;
use Illuminate\Http\JsonResponse;

/**
 * Class PaymentController
 * @package App\Http\Controllers
 */
class PaymentController extends Controller
{
    /**
     * @var PaymentServiceInterface
     */
    protected $paymentService;

    /**
     * PaymentController constructor.
     * @param PaymentServiceInterface $paymentService
     */
    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * @param CreatePaymentRequest $createPaymentRequest
     * @return JsonResponse
     */
    public function createPayment(CreatePaymentRequest $createPaymentRequest): JsonResponse
    {
        $response = $this->paymentService->createPayment($createPaymentRequest->validated());

        if(!$response['status']){
            return response()->json($response['message'], 500);
        }

        return response()->json($response['message'], 201);
    }
}
