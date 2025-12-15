<?php

use App\Http\Controllers\PurchaseOrderController;
use Illuminate\Support\Facades\Route;

Route::post('/purchase_order/store', [PurchaseOrderController::class, 'store']);