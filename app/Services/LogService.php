<?php


namespace App\Services;


use App\Repositories\Interfaces\LogRepositoryInterface;
use App\Services\Interfaces\LogServiceInterface;

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
    public function __construct(
        LogRepositoryInterface $logRepository
    )
    {
        $this->logRepository = $logRepository;
    }

    /**
     * @return array
     */
    public function getLogs():array
    {
        $data = [];

        $listLogs = $this->logRepository->listLogs();
        if(empty($listLogs->toArray())){
            return ['status' => false, 'message' => __('cash_flow.no_logs')];
        }

        foreach ($listLogs as $listLog) {
            $data[$listLog->id] = ['value' => $listLog->value];
            foreach ($listLog->cashFlow as $cashFlow){
                $data[$listLog->id]['data'][] = [
                    'value' => $cashFlow->value,
                    'count' => $cashFlow->count,
                    'denomination' => $cashFlow->denomination
                ];
            }
        }

        return ['status' => true, 'message' => $data];
    }
}
