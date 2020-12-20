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
        $cashFlow = $this->cashFlow->where('value', $data['value'])->first();
        if($cashFlow){
            $this->cashFlowAddCount($cashFlow->id, $data['count']);
            return $cashFlow;
        }

        return $this->cashFlow->create($data);
    }

    /**
     * @param int $value
     * @return CashFlow
     */
    public function getCashFlowByValue(int $value): CashFlow
    {
        return $this->cashFlow->where('value', $value)->first();
    }

    /**
     * @param int $id
     * @param $count
     * @return bool
     */
    public function cashFlowAddCount(int $id, $count): bool
    {
        $cashFlow = $this->cashFlow->where('id', $id)->first();
        $cashFlow->count = $cashFlow->count+ $count;

        return $cashFlow->save();
    }

    /**
     * @param int $id
     * @param $count
     * @return bool
     */
    public function cashFlowSubtractCount(int $id, $count): bool
    {
        $cashFlow = $this->cashFlow->where('id', $id)->first();
        $cashFlow->count = $cashFlow->count - $count;

        return $cashFlow->save();
    }
}
