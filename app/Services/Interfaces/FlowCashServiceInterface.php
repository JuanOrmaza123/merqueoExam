<?php


namespace App\Services\Interfaces;

/**
 * Interface FlowCashServiceInterface
 * @package App\Services\Interfaces
 */
interface FlowCashServiceInterface
{
    /**
     * This function load base for cash flow
     *
     * @param array $data
     * @return array
     */
    public function createBaseCashFlow(array $data): array;

    /**
     * @return array
     */
    public function getStatusCashFlow(): array;
}
