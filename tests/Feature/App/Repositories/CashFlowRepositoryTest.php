<?php

namespace App\Repositories;

use App\Models\CashFlow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class CashFlowRepositoryTest
 * @package App\Repositories
 */
class CashFlowRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This function is verified persistence data of database
     */
    public function testCreateCashFlow(): void
    {
        $data = factory(CashFlow::class)->make()->toArray();

        $cashFlowRepository = new CashFlowRepository(new CashFlow());
        $response = $cashFlowRepository->createCashFlow($data);

        $this->assertInstanceOf(CashFlow::class, $response);
        $this->assertDatabaseHas('cash_flow', $data);
    }

    public function testCreateCashFlowAddCount(): void
    {
        $data = factory(CashFlow::class)->create()->toArray();

        $cashFlowRepository = new CashFlowRepository(new CashFlow());
        $response = $cashFlowRepository->createCashFlow($data);

        $data['count'] += $data['count'];

        $this->assertInstanceOf(CashFlow::class, $response);
        $this->assertDatabaseHas('cash_flow', $data);
    }
}
