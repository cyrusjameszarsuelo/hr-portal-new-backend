<?php

use App\Http\Controllers\FunctionPositionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MicrosoftAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/function-positions', [FunctionPositionController::class, 'index']);
Route::get('/function-positions/tree', [FunctionPositionController::class, 'tree']);
Route::get('/function-positions/flat', [FunctionPositionController::class, 'flat']);
Route::get('/function-positions/nested', [FunctionPositionController::class, 'nested']);
Route::get('/auth/redirect', [MicrosoftAuthController::class, 'redirectToMicrosoft']);
Route::get('/connect', [MicrosoftAuthController::class, 'handleMicrosoftCallback']);
