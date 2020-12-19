<?php

namespace App\Entities\CashFlow\Repositories\Interfaces;

use App\Entities\CashFlow\CashFlow;
use App\Entities\CashFlow\Repositories\Interfaces\CashFlowRepositoryInterface;
use Illuminate\Database\QueryException;

class CashFlowRepository implements CashFlowRepositoryInterface{
    private $columns = ['id', 'denomination', 'value', 'count'];

    public function __construct(CashFlow $cashFlow)
    {
        $this->model = $cashFlow;
    }

    public function listCashFlows()
    {
        try {
            return  $this->model
                ->get($this->columns);
        } catch (QueryException $e) {
            abort(503, $e->getMessage());
        }
    }

    public function createCashFlow(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            abort(503, $e->getMessage());
        }
    }
}
