<?php

namespace App\Entities\CashFlow\Repositories\Interfaces;

interface CashFlowRepositoryInterface{
    public function listCashFlows();

    public function createCashFlow(array $data);
}
