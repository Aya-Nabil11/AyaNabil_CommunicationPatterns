<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

// Fetch chat history
Route::get('/chat/{customerId}/{agentId}', [ChatController::class, 'history']);

// Send message (fallback if WebSockets not available)
Route::post('/chat/send', [ChatController::class, 'send']);
