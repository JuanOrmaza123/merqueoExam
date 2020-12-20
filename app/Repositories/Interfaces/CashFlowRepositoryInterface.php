<?php

namespace App\Repositories\Interfaces;

use App\Models\CashFlow;

/**
 * Interface CashFlowRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface CashFlowRepositoryInterface
{
    /**
     * @param array|string[] $columns
     * @return array
     */
    public function listCashFlows(array $columns = ['*']): array;

    /**
     * @param array $data
     * @return CashFlow
     */
    public function createCashFlow(array $data): CashFlow;
}
