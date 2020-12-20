<?php

namespace App\Services;

use App\Repositories\Interfaces\CashFlowRepositoryInterface;
use App\Repositories\Interfaces\LogRepositoryInterface;
use App\Services\Interfaces\FlowCashServiceInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class FlowCashService
 * @package App\Services
 */
class FlowCashService implements FlowCashServiceInterface
{
    /**
     * @var CashFlowRepositoryInterface
     */
    protected $cashFlowRepository;

    /**
     * @var LogRepositoryInterface
     */
    protected $logRepository;

    /**
     * FlowCashService constructor.
     * @param CashFlowRepositoryInterface $cashFlowRepository
     * @param LogRepositoryInterface $logRepository
     */
    public function __construct(CashFlowRepositoryInterface $cashFlowRepository, LogRepositoryInterface $logRepository)
    {
        $this->cashFlowRepository = $cashFlowRepository;
        $this->logRepository = $logRepository;
    }

    /**
     * This function load base for cash flow
     *
     * @param array $data
     * @return array
     */
    public function createBaseCashFlow(array $data): array
    {
        try {
            //DB::beginTransaction();
            $cashFlow = $this->cashFlowRepository->createCashFlow($data);
            dd($cashFlow);
            $dataLog = ['type' => 'load', 'value' => $cashFlow->value];
            $log = $this->logRepository->createLog($dataLog);
            $cashFlow->logs()->attach($log, ['cash_flow_count' => $cashFlow->count]);
            //DB::commit();

            return ['status' => true, 'message' => __('cash_flow.create_success')];
        }catch (\Exception $e){
            DB::rollBack();

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
