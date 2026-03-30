<?php

namespace App\Providers;

use App\UseCases\CreditLimitBalances\GetCreditLimitBalanceFactory;
use App\UseCases\CreditLimitBalances\GetMonthlyCreditLimitBalanceStrategy;
use App\UseCases\CreditLimitBalances\UpdateCreditLimitBalanceFactory;
use App\UseCases\CreditLimitBalances\UpdateMonthlyCreditLimitBalanceStrategy;
use App\UseCases\CreditLimits\CreateCreditLimitFactory;
use App\UseCases\CreditLimits\CreateCreditLimitMonthlyStrategy;
use App\UseCases\Home\GetDataToDashboardFactory;
use App\UseCases\Home\LoadBudgetHealthUseCase;
use App\UseCases\Home\LoadDatatoStatisticsCardsUseCase;
use App\UseCases\Home\LoadLimitVsPurchaseOrdersChartUseCase;
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
                $app->make(LoadLimitVsPurchaseOrdersChartUseCase::class),
                $app->make(LoadBudgetHealthUseCase::class)
            ]);
        });

        $this->app->singleton(GetCreditLimitBalanceFactory::class, function ($app) {
            return new GetCreditLimitBalanceFactory([
                $app->make(GetMonthlyCreditLimitBalanceStrategy::class),
            ]);
        });

        $this->app->singleton(UpdateCreditLimitBalanceFactory::class, function ($app) {
            return new UpdateCreditLimitBalanceFactory([
                $app->make(UpdateMonthlyCreditLimitBalanceStrategy::class),
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
