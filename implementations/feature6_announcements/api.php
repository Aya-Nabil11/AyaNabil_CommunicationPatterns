<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;

Route::post('/announcements', [AnnouncementController::class, 'store']);
Route::get('/announcements', [AnnouncementController::class, 'index']);
