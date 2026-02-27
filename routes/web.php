<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CreditLimitController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\AuthenticatedMiddleware;
use App\Http\Middleware\NotAuthenticatedMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(NotAuthenticatedMiddleware::class)->get('/entrar', [HomeController::class, 'login'])->name('view.login');
Route::post('/validar-login', [AuthenticationController::class, 'login'])->name('auth.login');
Route::get('/sair', [AuthenticationController::class, 'logout'])->name('auth.logout');

Route::middleware(AuthenticatedMiddleware::class)->group(function(){
    Route::get('/dashboard', [HomeController::class, 'home'])->name('view.home');
    Route::get('/dashboard/load/cards', [HomeController::class, 'loadCards'])->name('view.home.load.cards');


    Route::get('/gerenciar/limites/listagem', [CreditLimitController::class, 'index'])->name('manage.limits.index');
    Route::get('/gerenciar/limites/novo', [CreditLimitController::class, 'create'])->name('manage.limits.create');
    Route::post('/gerenciar/limites/novo', [CreditLimitController::class, 'store'])->name('manage.limits.store');
    Route::get('/gerenciar/limites/yajra/listagem', [CreditLimitController::class, 'list'])->name('manage.limits.list');


    Route::get('/dados-externos/ordens-de-compra/listagem', [PurchaseOrderController::class, 'index'])->name('external-data.purchase-order.index');
    Route::get('/dados-externos/ordens-de-compra/yajra/listagem', [PurchaseOrderController::class, 'list'])->name('external-data.purchase-order.list');
    Route::get('/dados-externos/ordens-de-compra/{ordem_compra_id}', [PurchaseOrderController::class, 'show'])->name('external-data.purchase-order.show');
    
    Route::get('/dados-externos/transacoes/listagem', [TransactionController::class, 'index'])->name('external-data.transaction.index');


    Route::get('/configuracao', [SettingsController::class, 'index'])->name('settings.settings.index');
    Route::post('/configuracao/validate-balance', [SettingsController::class, 'balanceValidationStore'])->name('settings.settings.validate-balance.store');
    Route::post('/configuracao/define-period-type-for-usage-type', [SettingsController::class, 'definePeriodTypeForUsageTypeStore'])->name('settings.settings.define-period-for-usage.store');

});