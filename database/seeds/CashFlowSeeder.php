<?php

use \Carbon\Carbon;
use Illuminate\Database\Seeder;
use \App\Models\Log;
use \App\Models\CashFlow;
use \Illuminate\Support\Facades\DB;

class CashFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataCashFlow = [
            [
                'denomination' => 'bill',
                'value' => 100000,
                'count' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 50000,
                'count' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 20000,
                'count' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 10000,
                'count' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 5000,
                'count' => 12,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 1000,
                'count' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'denomination' => 'coin',
                'value' => 500,
                'count' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'denomination' => 'coin',
                'value' => 200,
                'count' => 20,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'denomination' => 'coin',
                'value' => 100,
                'count' => 20,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'denomination' => 'coin',
                'value' => 50,
                'count' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        $totalCashFlow = 0;
        foreach ($dataCashFlow as $key => $cashFlow){
            $totalCashFlow += $cashFlow['value']*$cashFlow['count'];
        }

        $log = factory(Log::class)->create([
            'type' => 'load',
            'value' => $totalCashFlow
        ]);

        factory(Log::class)->create([
            'type' => 'egress',
            'value' => 1000
        ]);

        foreach ($dataCashFlow as $key => $cashFlow) {
            $dataCashFlow = factory(CashFlow::class)->create($cashFlow);
            DB::table('cash_flow_log')
                ->insert([
                    'cash_flow_id' => $dataCashFlow->id,
                    'log_id' => $log->id,
                    'cash_flow_count' => $cashFlow['count']
                ]);
        }
    }
}
