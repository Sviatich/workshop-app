<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FileUploadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/upload', [FileUploadController::class, 'upload']);

Route::post('/calculate', [ConfiguratorController::class, 'calculate']);

Route::post('/order', [OrderController::class, 'store']);
