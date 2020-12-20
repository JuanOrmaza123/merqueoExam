<?php

namespace App\Repositories\Interfaces;

use App\Models\Log;

/**
 * Interface LogRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface LogRepositoryInterface
{

    /**
     * @param array|string[] $columns
     * @return array
     */
    public function listLogs(array $columns = ['*']): array;

    /**
     * @param array $data
     * @return Log
     */
    public function createLog(array $data): Log;
}
