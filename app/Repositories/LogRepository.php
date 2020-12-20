<?php

namespace App\Repositories;

use App\Models\Log;
use App\Repositories\Interfaces\LogRepositoryInterface;

/**
 * Class LogRepository
 * @package App\Repositories
 */
class LogRepository implements LogRepositoryInterface
{
    /**
     * @var Log
     */
    protected $log;

    /**
     * LogRepository constructor.
     * @param Log $log
     */
    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    /**
     * @param array|string[] $columns
     * @return array
     */
    public function listLogs(array $columns = ['*']): array
    {
        $logList = $this->log->get($columns);

        return (empty($logList)) ? [] : $logList->toArray();
    }

    /**
     * @param array $data
     * @return Log
     */
    public function createLog(array $data): Log
    {
        return $this->log->create($data);
    }
}
