<?php

namespace App\Providers;

use App\Entities\CashFlow\Repositories\Interfaces\CashFlowRepository;
use App\Entities\CashFlow\Repositories\Interfaces\CashFlowRepositoryInterface;
use App\Entities\Logs\Repositories\Interfaces\LogRepository;
use App\Entities\Logs\Repositories\Interfaces\LogRepositoryInterface;
use App\Entities\Logs\Repositories\Interfaces\PaymentRepository;
use App\Entities\Payments\Repositories\Interfaces\PaymentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CashFlowRepositoryInterface::class,
            CashFlowRepository::class
        );

        $this->app->bind(
            LogRepositoryInterface::class,
            LogRepository::class
        );

        $this->app->bind(
            PaymentRepositoryInterface::class,
            PaymentRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
