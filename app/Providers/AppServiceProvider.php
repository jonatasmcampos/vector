<?php

namespace App\Providers;

use App\UseCases\CreditLimits\CreateCreditLimitFactory;
use App\UseCases\CreditLimits\CreateCreditLimitMonthlyStrategy;
use App\UseCases\Home\GetDataToDashboardFactory;
use App\UseCases\Home\LoadDatatoStatisticsCardsUseCase;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CreateCreditLimitFactory::class, function ($app) {
            return new CreateCreditLimitFactory([
                $app->make(CreateCreditLimitMonthlyStrategy::class),
            ]);
        });

        $this->app->singleton(GetDataToDashboardFactory::class, function ($app) {
            return new GetDataToDashboardFactory([
                $app->make(LoadDatatoStatisticsCardsUseCase::class),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
