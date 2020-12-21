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

    /**
     * @param int $value
     * @return CashFlow
     */
    public function getCashFlowByValue(int $value): CashFlow;

    /**
     * @param int $id
     * @param $count
     * @return bool
     */
    public function cashFlowAddCount(int $id, $count): bool;

    /**
     * @param int $id
     * @param $count
     * @return bool
     */
    public function cashFlowSubtractCount(int $id, $count): bool;

    /**
     * @return bool
     */
    public function setEmptyFlowCash(): bool;
}
