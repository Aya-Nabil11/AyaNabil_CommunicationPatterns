<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuImageController;

Route::post('/menu-images/upload', [MenuImageController::class, 'upload']);
Route::get('/menu-images/{id}/status', [MenuImageController::class, 'status']);
