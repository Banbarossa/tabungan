<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/webhook/device-status', [WebhookController::class, 'handleDeviceStatus']);
Route::match(['get', 'post'], '/webhook/message-status', [WebhookController::class, 'handleMessageStatus']);
