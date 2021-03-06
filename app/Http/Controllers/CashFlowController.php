<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCashFlowRequest;
use App\Services\Interfaces\FlowCashServiceInterface;
use Illuminate\Http\JsonResponse;

/**
 * Class CashFlowController
 * @package App\Http\Controllers
 */
class CashFlowController extends Controller
{
    /**
     * @var FlowCashServiceInterface
     */
    protected $flowCashService;

    /**
     * CashFlowController constructor.
     * @param FlowCashServiceInterface $flowCashService
     */
    public function __construct(FlowCashServiceInterface $flowCashService)
    {
        $this->flowCashService = $flowCashService;
    }

    /**
     * @param CreateCashFlowRequest $createCashFlowRequest
     * @return JsonResponse
     */
    public function createBaseCashFlow(CreateCashFlowRequest $createCashFlowRequest): JsonResponse
    {
        $response = $this->flowCashService->createBaseCashFlow($createCashFlowRequest->validated());

        if(!$response['status']){
            return response()->json($response['message'], 500);
        }

        return response()->json($response['message'], 201);
    }

    /**
     * @return JsonResponse
     */
    public function getStatusCashFlow(): JsonResponse
    {
        $response = $this->flowCashService->getStatusCashFlow();

        return response()->json($response['message'], 200);
    }

    /**
     * @return JsonResponse
     */
    public function setEmptyFlowCash(): JsonResponse
    {
        $response = $this->flowCashService->setEmptyFlowCash();

        if(!$response['status']){
            return response()->json($response['message'], 500);
        }

        return response()->json($response['message'], 200);
    }
}
