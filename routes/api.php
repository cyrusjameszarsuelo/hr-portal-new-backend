<?php

use App\Http\Controllers\FunctionPositionController;
use App\Http\Controllers\OrgStructureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MicrosoftAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/auth/redirect', [MicrosoftAuthController::class, 'redirectToMicrosoft']);
Route::get('/connect', [MicrosoftAuthController::class, 'handleMicrosoftCallback']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/function-positions/nested', [FunctionPositionController::class, 'nested']);
    Route::get('/functions/{id}', [FunctionPositionController::class, 'getFunctionById']);
    Route::get('/subfunctions/{id}', [FunctionPositionController::class, 'getSubFunctionById']);
    Route::post('/manage-function', [FunctionPositionController::class, 'manageFunction']);
    Route::get('/description/{id}', [FunctionPositionController::class, 'getDescriptionById']);
    Route::post('/manage-description', [FunctionPositionController::class, 'manageDescription']);
    Route::post('/delete-function', [FunctionPositionController::class, 'deleteFunction']);
    Route::get('/organization-structure', [OrgStructureController::class, 'index']);
    Route::put('/organization-structure/update', [OrgStructureController::class, 'update']);
    Route::delete('/organization-structure/delete/{id}', [OrgStructureController::class, 'destroy']);
    Route::post('/organization-structure/add/{pid}', [OrgStructureController::class, 'store']);
});



