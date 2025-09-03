<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SdekController;
use App\Http\Controllers\Bitrix24WebhookController;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/upload', [FileUploadController::class, 'upload']);

Route::post('/calculate', [ConfiguratorController::class, 'calculate']);

Route::post('/order', [OrderController::class, 'store'])
    ->middleware(ProtectAgainstSpam::class);

// CDEK (СДЭК) API endpoints for PVZ search and price calculation
Route::get('/sdek/cities', [SdekController::class, 'cities']);
Route::get('/sdek/pvz', [SdekController::class, 'pvz']);
Route::post('/sdek/calc/pvz', [SdekController::class, 'calcPvz']);
Route::post('/sdek/calc/courier', [SdekController::class, 'calcCourier']);

// Bitrix24 robot webhook to update public order status
// Accepts GET or POST without custom headers; use token in query/body
Route::match(['GET','POST'], '/b24/status', [Bitrix24WebhookController::class, 'updateStatus']);
