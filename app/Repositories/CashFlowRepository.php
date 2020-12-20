<?php

namespace App\Repositories;

use App\Models\CashFlow;
use App\Repositories\Interfaces\CashFlowRepositoryInterface;

/**
 * Class CashFlowRepository
 * @package App\Repositories
 */
class CashFlowRepository implements CashFlowRepositoryInterface
{

    /**
     * @var CashFlow
     */
    protected $cashFlow;

    /**
     * CashFlowRepository constructor.
     * @param CashFlow $cashFlow
     */
    public function __construct(CashFlow $cashFlow)
    {
        $this->cashFlow = $cashFlow;
    }

    /**
     * @param array|string[] $columns
     * @return array
     */
    public function listCashFlows(array $columns = ['*']): array
    {
        $cashFlowList = $this->cashFlow->get($columns);

        return (empty($cashFlowList)) ? [] : $cashFlowList->toArray();
    }

    /**
     * @param array $data
     * @return CashFlow
     */
    public function createCashFlow(array $data): CashFlow
    {
        return $this->cashFlow->create($data);
    }
}
