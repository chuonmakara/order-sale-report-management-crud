<?php

use App\Http\Controllers\ReportOrderSaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('report-order-sales.index');
});

Route::resource('report-order-sales', ReportOrderSaleController::class);
Route::get('report-order-sales/export/csv', [ReportOrderSaleController::class, 'export'])->name('report-order-sales.export');
?>