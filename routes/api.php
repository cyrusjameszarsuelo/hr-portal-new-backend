<?php

use App\Http\Controllers\FunctionPositionController;
use App\Http\Controllers\OrgStructureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/function-positions/nested', [FunctionPositionController::class, 'nested']);
Route::get('/functions/{id}', [FunctionPositionController::class, 'getFunctionById']);
Route::get('/subfunctions/{id}', [FunctionPositionController::class, 'getSubFunctionById']);
Route::post('/manage-function', [FunctionPositionController::class, 'manageFunction']);
Route::get('/description/{id}', [FunctionPositionController::class, 'getDescriptionById']);
Route::post('/manage-description', [FunctionPositionController::class, 'manageDescription']);
Route::post('/delete-function', [FunctionPositionController::class, 'deleteFunction']);
Route::get('/organization-structure', [OrgStructureController::class, 'index']);


