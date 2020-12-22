<?php

namespace App\Services;

use App\Repositories\Interfaces\LogRepositoryInterface;
use App\Services\Interfaces\LogServiceInterface;

/**
 * Class LogService
 * @package App\Services
 */
class LogService implements LogServiceInterface
{
    /**
     * @var LogRepositoryInterface
     */
    protected $logRepository;

    /**
     * LogService constructor.
     * @param LogRepositoryInterface $logRepository
     */
    public function __construct(LogRepositoryInterface $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        $data = [];

        $listLogs = $this->logRepository->listLogs();

        if (empty($listLogs)) {
            return ['status' => false, 'message' => __('cash_flow.no_logs')];
        }

        foreach ($listLogs as $key => $listLog) {
            $data[$key] = ['type' => $listLog['type'], 'id' =>$listLog['id'],'value' => $listLog['value']];
            foreach ($listLog['cash_flow'] as $cashFlow) {
                $data[$key]['movements'][] = [
                    'value' => $cashFlow['value'],
                    'count' => $cashFlow['pivot']['cash_flow_count'],
                    'denomination' => $cashFlow['denomination']
                ];
            }
        }

        return ['status' => true, 'message' => $data];
    }

    /**
     * @param string $date
     * @return array
     */
    public function getStatusByDate(string $date): array
    {
        $totalCashFlow = 0;

        $listLogs = $this->logRepository->getStatusByDate($date);

        if (empty($listLogs)) {
            return ['status' => false, 'message' => __('cash_flow.no_logs')];
        }

        foreach ($listLogs as $listLog) {
            if($listLog['type'] == 'egress'){
                $totalCashFlow -= $listLog['value'];
                continue;
            }
            $totalCashFlow += $listLog['value'];

        }

        return ['status' => true, 'message' => ['total_cash_flow' => $totalCashFlow]];
    }
}
