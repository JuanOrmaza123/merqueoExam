<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CashFlowRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * Class CashFlowControllerTest
 * @package App\Http\Controllers
 */
class CashFlowControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    /**
     * @var mixed
     */
    protected $body;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->body = $this->getDataCreate();
    }

    /**
     * @return mixed
     */
    private function getDataCreate()
    {
        $body = file_get_contents(__DIR__ . '/../../../RequestFiles/bodyCashFlowCreate.json');
        return json_decode($body, true);
    }

    /**
     * This test case successful in endpoint load cash flow
     */
    public function testCreateBaseCashFlowSuccess(): void
    {
        $response = $this->post(route('cashFlow.create'), $this->body, ['Accept' => 'application/json']);

        $response->assertStatus(201);

        $this->assertDatabaseHas('cash_flow', $this->body);
        $this->assertDatabaseHas('logs', ['type' => 'load', 'value' => $this->body['value']]);
    }

    /**
     *
     */
    public function testCreateBaseCashFlowValidationFields(): void
    {
        $response = $this->post(route('cashFlow.create'), [], ['Accept' => 'application/json']);

        $response->assertStatus(422);

        $response->assertJson(
            [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'denomination' => [
                        'The denomination field is required.'
                    ],
                    'value' => [
                        'The value field is required.'
                    ],
                    'count' => [
                        'The count field is required.'
                    ]
                ]
            ]
        );
    }

    /**
     * This test case error in endpoint load cash flow
     */
    public function testCreateBaseCashFlowError(): void
    {
        $cashFlowRepositoryMock = \Mockery::mock(CashFlowRepositoryInterface::class);

        $cashFlowRepositoryMock->shouldReceive('createCashFlow')
            ->withArgs($this->body)
            ->andThrow(new \Exception('error'))
            ->getMock();

        $this->app->instance(CashFlowRepositoryInterface::class, $cashFlowRepositoryMock);
        $response = $this->post(route('cashFlow.create'), $this->body, ['Accept' => 'application/json']);

        $response->assertStatus(500);
    }

    /**
     * This test is successful on endpoint Get Status Cash Flow
     */
    public function testGetStatusFlowCashSuccess(): void
    {
        $this->artisan('db:seed --class=CashFlowSeeder');
        $response = $this->get(route('cashFlow.getStatus'), ['Accept' => 'application/json']);
        $response->assertStatus(200);

    }

    /**
     * This case is set empty cashflow success
     */
    public function testSetEmptyFlowCashSuccess(): void
    {
        $this->artisan('db:seed --class=CashFlowSeeder');

        $response = $this->get(route('cashFlow.setEmpty'), ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    /**
     * This case is set empty cashflow error
     */
    public function testSetEmptyFlowCashError(): void
    {
        $response = $this->get(route('cashFlow.setEmpty'), ['Accept' => 'application/json']);
        $response->assertStatus(500);
    }
}
