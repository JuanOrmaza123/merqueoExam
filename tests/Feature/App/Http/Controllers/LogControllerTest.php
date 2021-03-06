<?php


namespace App\Http\Controllers;


use App\Models\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class LogControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * This test is case getLogs success
     */
    public function testGetLogsSuccess(): void
    {
        $this->artisan('db:seed --class=CashFlowSeeder');

        $response = $this->get(route('log.getLogs'), ['Accept' => 'application/json']);

        $response->assertStatus(200);
    }

    /**
     * This test is case getLogs Error
     */
    public function testGetLogsError(): void
    {
        $response = $this->get(route('log.getLogs'), ['Accept' => 'application/json']);

        $response->assertStatus(500);
    }

    /**
     * This case is endpoint get status by date Success
     */
    public function testGetStatusByDateSuccess(): void
    {
        $length = 5;
        $logsEntryFactory = factory(Log::class, $length)->create(['created_at' => '2020-12-20 01:00:00', 'type' => 'entry'])->toArray();
        $logsEgressFactory = factory(Log::class, $length)->create(['created_at' => '2020-12-20 01:00:00', 'type' => 'egress'])->toArray();
        $totalCashFlow = 0;

        for ($i = 0; $length > $i; $i++){
            $totalCashFlow += $logsEntryFactory[$i]['value'];
            $totalCashFlow -= $logsEgressFactory[$i]['value'];
        }

        $response = $this->get(route('log.getStatusByDate',
            ['date' => '2020-12-31 23:59:59']),
            ['Accept' => 'application/json']
        );

        $response->assertStatus(200);
        $response->assertJson(['total_cash_flow' => $totalCashFlow]);
    }

    /**
     * This case is endpoint get status by date error
     */
    public function testGetStatusByDateError(): void
    {
        $response = $this->get(route('log.getStatusByDate',
            ['date' => '2020-12-31 23:59:59']),
            ['Accept' => 'application/json']
        );

        $response->assertStatus(500);
    }
}
