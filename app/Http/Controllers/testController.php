<?php

namespace App\Http\Controllers;

use App\Entities\CashFlow\CashFlow;
use App\Entities\Logs\Log;
use App\Entities\Payments\Payment;
use Illuminate\Http\Request;


class testController extends Controller
{
    public function test(){
        $test = new Payment();

        dd($test->find(1)->cashFlow);
    }
}
