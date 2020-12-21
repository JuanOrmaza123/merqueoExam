<?php


namespace Tests\Unit\App\Services;


use App\Models\CashFlow;
use App\Models\Log;
use App\Models\Payment;
use App\Repositories\Interfaces\CashFlowRepositoryInterface;
use App\Repositories\Interfaces\LogRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Services\PaymentService;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    /**
     * @var PaymentRepositoryInterface|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $paymentRepositoryMock;

    /**
     * @var CashFlowRepositoryInterface|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $cashFlowRepositoryMock;

    /**
     * @var LogRepositoryInterface|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $logRepositoryMock;

    /**
     * @var PaymentService
     */
    protected $paymentService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentRepositoryMock = \Mockery::mock(PaymentRepositoryInterface::class);
        $this->cashFlowRepositoryMock = \Mockery::mock(CashFlowRepositoryInterface::class);
        $this->logRepositoryMock = \Mockery::mock(LogRepositoryInterface::class);

        $this->paymentService = new PaymentService(
            $this->paymentRepositoryMock,
            $this->cashFlowRepositoryMock,
            $this->logRepositoryMock
        );
    }

    public function testCreatePaymentSuccess()
    {
        $data = ["total_customer" => 50000, "total_purchase" => 10000];

        $this->cashFlowRepositoryMock->shouldReceive('listCashFlows')
            ->once()
            ->andReturn([
                [
                    'id' => 25,
                    'denomination' => 'bill',
                    'value' => 20000,
                    'count' => 8,
                ]
            ])
            ->getMock();

        $paymentFactory = factory(Payment::class)->make($data);

        $this->paymentRepositoryMock->shouldReceive('createPayment')
            ->once()
            ->with($data)
            ->andReturn($paymentFactory);

        $dataLogEntry = ['type' => 'entry', 'value' => $paymentFactory->total_customer];

        $logModel = \Mockery::mock(Log::class)
            ->shouldReceive('getAttribute')
            ->getMock();

        $this->logRepositoryMock->shouldReceive('createLog')
            ->once()
            ->with($dataLogEntry)
            ->andReturn($logModel);

        $belongsToManyMock = \Mockery::mock(BelongsToMany::class)
            ->shouldReceive('attach')
            ->andReturn(true)
            ->getMock();

        $cashFlowModelMock = \Mockery::mock(CashFlow::class)
            ->shouldReceive('getAttribute')
            ->andReturn(1)
            ->getMock()
            ->shouldReceive('logs')
            ->twice()
            ->andReturn($belongsToManyMock)
            ->getMock();

        $this->cashFlowRepositoryMock->shouldReceive('getCashFlowByValue')
            ->once()
            ->with($data['total_customer'])
            ->andReturn($cashFlowModelMock)
            ->getMock()
            ->shouldReceive('cashFlowAddCount')
            ->with(1, 1)
            ->andReturn(true);

        $totalBackMoney = $data['total_customer'] - $data['total_purchase'];
        $dataLogEgress = ['type' => 'egress', 'value' => $totalBackMoney];

        $this->logRepositoryMock->shouldReceive('createLog')
            ->once()
            ->with($dataLogEgress)
            ->andReturn($logModel);

        $this->cashFlowRepositoryMock->shouldReceive('getCashFlowByValue')
            ->once()
            ->with(20000)
            ->andReturn($cashFlowModelMock)
            ->getMock()
            ->shouldReceive('cashFlowAddCount')
            ->with(1, 1)
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('cashFlowSubtractCount')
            ->with(1, 2)
            ->andReturn(true)
            ->getMock();

        $response = $this->paymentService->createPayment($data);

        $this->assertEquals(
            [
                'status' => true,
                'message' => 'Payment success',
                'backMoney' => [
                    20000 => [
                        'value' => 20000,
                        'count' => 2,
                    ]
                ]
            ], $response
        );
    }

    public function testCreatePaymentErrorNoGetBackMoney()
    {
        $this->cashFlowRepositoryMock->shouldReceive('listCashFlows')
            ->once()
            ->andReturn([])
            ->getMock();

        $response = $this->paymentService->createPayment(['total_customer' => 600, 'total_purchase' => 50]);

        $this->assertEquals([
            'status' => false,
            'message' => "No get back money",
        ], $response);
    }

    public function testCreatePaymentErrorAddCount(){
        $data = ["total_customer" => 50000, "total_purchase" => 10000];

        $this->cashFlowRepositoryMock->shouldReceive('listCashFlows')
            ->once()
            ->andReturn([
                [
                    'id' => 25,
                    'denomination' => 'bill',
                    'value' => 20000,
                    'count' => 8,
                ]
            ])
            ->getMock();

        $paymentFactory = factory(Payment::class)->make($data);

        $this->paymentRepositoryMock->shouldReceive('createPayment')
            ->once()
            ->with($data)
            ->andReturn($paymentFactory);

        $dataLogEntry = ['type' => 'entry', 'value' => $paymentFactory->total_customer];

        $logModel = \Mockery::mock(Log::class)
            ->shouldReceive('getAttribute')
            ->getMock();

        $this->logRepositoryMock->shouldReceive('createLog')
            ->once()
            ->with($dataLogEntry)
            ->andReturn($logModel);

        $belongsToManyMock = \Mockery::mock(BelongsToMany::class)
            ->shouldReceive('attach')
            ->andReturn(true)
            ->getMock();

        $cashFlowModelMock = \Mockery::mock(CashFlow::class)
            ->shouldReceive('getAttribute')
            ->andReturn(1)
            ->getMock()
            ->shouldReceive('logs')
            ->once()
            ->andReturn($belongsToManyMock)
            ->getMock();

        $this->cashFlowRepositoryMock->shouldReceive('getCashFlowByValue')
            ->once()
            ->with($data['total_customer'])
            ->andReturn($cashFlowModelMock)
            ->getMock()
            ->shouldReceive('cashFlowAddCount')
            ->with(1, 1)
            ->andReturn(false);

        $response = $this->paymentService->createPayment($data);

        $this->assertEquals([
            'status' => false,
            'message' => "Ha ocurrido un error",
        ], $response);
    }

    public function testCreatePaymentErrorSubtractCount(){
        $data = ["total_customer" => 50000, "total_purchase" => 10000];

        $this->cashFlowRepositoryMock->shouldReceive('listCashFlows')
            ->once()
            ->andReturn([
                [
                    'id' => 25,
                    'denomination' => 'bill',
                    'value' => 20000,
                    'count' => 8,
                ]
            ])
            ->getMock();

        $paymentFactory = factory(Payment::class)->make($data);

        $this->paymentRepositoryMock->shouldReceive('createPayment')
            ->once()
            ->with($data)
            ->andReturn($paymentFactory);

        $dataLogEntry = ['type' => 'entry', 'value' => $paymentFactory->total_customer];

        $logModel = \Mockery::mock(Log::class)
            ->shouldReceive('getAttribute')
            ->getMock();

        $this->logRepositoryMock->shouldReceive('createLog')
            ->once()
            ->with($dataLogEntry)
            ->andReturn($logModel);

        $belongsToManyMock = \Mockery::mock(BelongsToMany::class)
            ->shouldReceive('attach')
            ->andReturn(true)
            ->getMock();

        $cashFlowModelMock = \Mockery::mock(CashFlow::class)
            ->shouldReceive('getAttribute')
            ->andReturn(1)
            ->getMock()
            ->shouldReceive('logs')
            ->twice()
            ->andReturn($belongsToManyMock)
            ->getMock();

        $this->cashFlowRepositoryMock->shouldReceive('getCashFlowByValue')
            ->once()
            ->with($data['total_customer'])
            ->andReturn($cashFlowModelMock)
            ->getMock()
            ->shouldReceive('cashFlowAddCount')
            ->with(1, 1)
            ->andReturn(true);

        $totalBackMoney = $data['total_customer'] - $data['total_purchase'];
        $dataLogEgress = ['type' => 'egress', 'value' => $totalBackMoney];

        $this->logRepositoryMock->shouldReceive('createLog')
            ->once()
            ->with($dataLogEgress)
            ->andReturn($logModel);

        $this->cashFlowRepositoryMock->shouldReceive('getCashFlowByValue')
            ->once()
            ->with(20000)
            ->andReturn($cashFlowModelMock)
            ->getMock()
            ->shouldReceive('cashFlowAddCount')
            ->with(1, 1)
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('cashFlowSubtractCount')
            ->with(1, 2)
            ->andReturn(false)
            ->getMock();

        $response = $this->paymentService->createPayment($data);

        $this->assertEquals([
            'status' => false,
            'message' => "Ha ocurrido un error",
        ], $response);
    }

}
