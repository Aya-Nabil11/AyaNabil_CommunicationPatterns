<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverLocationController;

Route::put('/orders/{id}/location', [DriverLocationController::class, 'update']);