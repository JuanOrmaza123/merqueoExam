<?php

use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'denomination' => 'bill',
                'value' => 50000,
                'count' => 1
            ],
            [
                'denomination' => 'bill',
                'value' => 20000,
                'count' => 1
            ],
            [
                'denomination' => 'bill',
                'value' => 10000,
                'count' => 10
            ],
            [
                'denomination' => 'coin',
                'value' => 500,
                'count' => 15
            ],
            [
                'denomination' => 'coin',
                'value' => 200,
                'count' => 20
            ]
        ];
        \App\Models\CashFlow::insert($data);
    }
}
