<?php


namespace App\Http\Controllers;


use App\Models\CashFlow;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * Class PaymentControllerTest
 * @package App\Http\Controllers
 */
class PaymentControllerTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * @var mixed
     */
    protected $body;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->body = $this->getDataCreate();
        $this->artisan('db:seed --class=CashFlowSeeder');
    }

    /**
     * @return mixed
     */
    private function getDataCreate()
    {
        $body = file_get_contents(__DIR__ . '/../../../RequestFiles/bodyPaymentCreate.json');
        return json_decode($body, true);
    }

    /**
     * This test case successful in endpoint create payment
     */
    public function testCreatePaymentSuccess(): void
    {

        $response = $this->post(route('payment.create'), $this->body, ['Accept' => 'application/json']);

        $response->assertStatus(201);
        $this->assertDatabaseHas('payments', $this->body);
        $this->assertDatabaseHas('logs', ['type' => 'entry', 'value' => $this->body['total_customer']]);
    }

    /**
     * This test case error on endpoint create payment
     */
    public function testCreatePaymentError(): void
    {
        $paymentRepositoryMock = \Mockery::mock(PaymentRepositoryInterface::class);

        $paymentRepositoryMock->shouldReceive('createPayment')
            ->withArgs($this->body)
            ->andThrow(new \Exception('error'))
            ->getMock();

        $this->app->instance(PaymentRepositoryInterface::class, $paymentRepositoryMock);

        $response = $this->post(route('payment.create'), $this->body, ['Accept' => 'application/json']);

        $response->assertStatus(500);
    }
}
