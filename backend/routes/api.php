<?php

use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('throttle:30,1')->group(function () {
    Route::post('/check', [VoucherController::class, 'check']);
    Route::post('/generate', [VoucherController::class, 'generate']);
});
