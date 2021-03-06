<?php

namespace Tests\Unit\App\Services;

use App\Models\CashFlow;
use App\Models\Log;
use App\Repositories\Interfaces\CashFlowRepositoryInterface;
use App\Repositories\Interfaces\LogRepositoryInterface;
use App\Services\FlowCashService;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

/**
 * Class FlowCashServiceTest
 * @package App\Services
 */
class FlowCashServiceTest extends TestCase
{
    /**
     * @var CashFlowRepositoryInterface|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $cashFlowRepositoryMock;

    /**
     * @var LogRepositoryInterface|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $logRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->cashFlowRepositoryMock = \Mockery::mock(CashFlowRepositoryInterface::class);
        $this->logRepositoryMock = \Mockery::mock(LogRepositoryInterface::class);
    }

    /**
     * This test case is Success for FlowCashService created
     */
    public function testCreateBaseCashFlowSuccessStatus(): void
    {
        $belongsToMany = \Mockery::mock(BelongsToMany::class)
            ->shouldReceive('attach')
            ->andReturn(true)
            ->getMock();

        $cashFlow = \Mockery::mock(CashFlow::class);
        $cashFlow->shouldReceive('getAttribute')
            ->getMock()
            ->shouldReceive('logs')
            ->once()
            ->andReturn($belongsToMany)
            ->getMock();

        $logModel = \Mockery::mock(Log::class)
            ->shouldReceive('getAttribute')
            ->getMock();

        $cashFlowRepository = \Mockery::mock(CashFlowRepositoryInterface::class);
        $cashFlowRepository->shouldReceive('createCashFlow')
            ->once()
            ->with(['test'])
            ->andReturn($cashFlow)
            ->getMock();

        $logRepository = \Mockery::mock(LogRepositoryInterface::class);
        $logRepository->shouldReceive('createLog')
            ->once()
            ->with(['type' => 'load', 'value' => $cashFlow->value])
            ->andReturn($logModel)
            ->getMock();

        $flowCashService = new FlowCashService($cashFlowRepository, $logRepository);
        $response = $flowCashService->createBaseCashFlow(['test']);

        $this->assertEquals(['status' => true, 'message' => __('cash_flow.create_success')], $response);
    }

    /**
     * This case is Error for FlowCashService created
     */
    public function testCreateBaseCashFlowErrorStatus()
    {
        $cashFlowRepository = \Mockery::mock(CashFlowRepositoryInterface::class);
        $cashFlowRepository->shouldReceive('createCashFlow')
            ->once()
            ->with(['test'])
            ->andThrow(new \Exception('error'))
            ->getMock();

        $logRepository = \Mockery::mock(LogRepositoryInterface::class);

        $flowCashService = new FlowCashService($cashFlowRepository, $logRepository);
        $response = $flowCashService->createBaseCashFlow(['test']);

        $this->assertEquals(['status' => false, 'message' => 'error'], $response);
    }

    /**
     * This case is Error for GetStatusCashFlow
     */
    public function testGetStatusCashFlowErrorStatus()
    {
        $cashFlowService = new FlowCashService($this->cashFlowRepositoryMock, $this->logRepositoryMock);
        $this->cashFlowRepositoryMock->shouldReceive('listCashFlows')
            ->once()
            ->withNoArgs()
            ->andReturn([])
            ->getMock();

        $response = $cashFlowService->getStatusCashFlow();

        $this->assertEquals(
            [
                'status' => true,
                'message' => [
                    'total_cash_flow' => 0,
                    'coin' => [],
                    'bill' => [],
                ]
            ], $response
        );
    }
}
