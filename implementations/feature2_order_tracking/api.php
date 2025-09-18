<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
Route::get('/orders/{id}/track', [OrderController::class, 'track']);
