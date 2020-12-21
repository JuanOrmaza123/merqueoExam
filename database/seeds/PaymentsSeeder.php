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
                'value' => 100000,
                'count' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 50000,
                'count' => 5,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 20000,
                'count' => 8,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 10000,
                'count' => 10,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 5000,
                'count' => 12,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'denomination' => 'bill',
                'value' => 1000,
                'count' => 30,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'denomination' => 'coin',
                'value' => 500,
                'count' => 15,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'denomination' => 'coin',
                'value' => 200,
                'count' => 20,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'denomination' => 'coin',
                'value' => 100,
                'count' => 20,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'denomination' => 'coin',
                'value' => 50,
                'count' => 50,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        ];
        \App\Models\CashFlow::insert($data);
    }
}
