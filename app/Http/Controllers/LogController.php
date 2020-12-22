<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetlogsByDateRequest;
use App\Services\Interfaces\LogServiceInterface;
use Illuminate\Http\JsonResponse;

/**
 * Class LogController
 * @package App\Http\Controllers
 */
class LogController extends Controller
{
    /**
     * @var LogServiceInterface
     */
    protected $logService;

    /**
     * LogController constructor.
     * @param LogServiceInterface $logService
     */
    public function __construct(
        LogServiceInterface $logService
    )
    {
        $this->logService = $logService;
    }

    /**
     * @return JsonResponse
     */
    public function getLogs(): JsonResponse
    {
        $response = $this->logService->getLogs();

        if (!$response['status']) {
            return response()->json($response['message'], 500);
        }

        return response()->json($response['message'], 200);
    }

    /**
     * @param GetlogsByDateRequest $getlogsByDateRequest
     * @return JsonResponse
     */
    public function getStatusByDate(GetlogsByDateRequest $getlogsByDateRequest): JsonResponse
    {
        $response = $this->logService->getStatusByDate($getlogsByDateRequest->validated()['date']);

        if (!$response['status']) {
            return response()->json($response['message'], 500);
        }

        return response()->json($response['message'], 200);
    }
}
