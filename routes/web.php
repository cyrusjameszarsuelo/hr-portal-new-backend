<?php

use App\Http\Controllers\FunctionPositionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/function-positions', [FunctionPositionController::class, 'index']);
Route::get('/function-positions/tree', [FunctionPositionController::class, 'tree']);
Route::get('/function-positions/flat', [FunctionPositionController::class, 'flat']);
Route::get('/function-positions/nested', [FunctionPositionController::class, 'nested']);
