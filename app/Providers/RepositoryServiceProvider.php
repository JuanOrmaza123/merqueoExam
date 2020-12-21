<?php

namespace App\Providers;

use App\Repositories\CashFlowRepository;
use App\Repositories\Interfaces\CashFlowRepositoryInterface;
use App\Repositories\Interfaces\LogRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\LogRepository;
use App\Repositories\PaymentRepository;
use App\Services\FlowCashService;
use App\Services\Interfaces\FlowCashServiceInterface;
use App\Services\Interfaces\LogServiceInterface;
use App\Services\Interfaces\PaymentServiceInterface;
use App\Services\LogService;
use App\Services\PaymentService;
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
        // Repositories
        $this->app->bind(CashFlowRepositoryInterface::class,CashFlowRepository::class);
        $this->app->bind(LogRepositoryInterface::class,LogRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class,PaymentRepository::class);

        // Services
        $this->app->bind(FlowCashServiceInterface::class,FlowCashService::class);
        $this->app->bind(PaymentServiceInterface::class,PaymentService::class);
        $this->app->bind(LogServiceInterface::class,LogService::class);
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
