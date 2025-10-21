<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\FunctionPositionController;
use App\Http\Controllers\OrgStructureController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MicrosoftAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/auth/redirect', [MicrosoftAuthController::class, 'redirectToMicrosoft']);
Route::get('/connect', [MicrosoftAuthController::class, 'handleMicrosoftCallback']);
Route::post('/logout/{id}', [UserController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {

    // User Controller
    Route::get('/get-user/{id}', [UserController::class, 'index']);

    // Function Position Controller
    Route::get('/function-positions/nested', [FunctionPositionController::class, 'nested']);
    Route::get('/description/{id}', [FunctionPositionController::class, 'getDescriptionById']);
    Route::post('/reorder-functions', [FunctionPositionController::class, 'reorderFunctions']);
    Route::post('/reorder-subfunctions', [FunctionPositionController::class, 'reorderSubfunctions']);
    Route::post('/reorder-descriptions', [FunctionPositionController::class, 'reorderDescriptions']);
    Route::get('/functions/{id}', [FunctionPositionController::class, 'getFunctionById']);
    Route::get('/subfunctions/{id}', [FunctionPositionController::class, 'getSubFunctionById']);
    Route::post('/manage-function', [FunctionPositionController::class, 'manageFunction']);
    Route::post('/manage-description', [FunctionPositionController::class, 'manageDescription']);
    Route::post('/delete-function', [FunctionPositionController::class, 'deleteFunction']);

    // Organization Structure Controller
    Route::get('/organization-structure', [OrgStructureController::class, 'index']);
    Route::put('/organization-structure/update', [OrgStructureController::class, 'update']);
    Route::delete('/organization-structure/delete/{id}', [OrgStructureController::class, 'destroy']);
    Route::post('/organization-structure/add/{pid}', [OrgStructureController::class, 'store']);
    Route::get('/get-head-count', [OrgStructureController::class, 'getHeadCount']);
    Route::get('/get-count-per-position', [OrgStructureController::class, 'getCountPerPosition']);
    Route::post('/upload-image', [OrgStructureController::class, 'uploadImage']);


    // Audit Log Controller
    Route::get('/audit-logs/{id}', [AuditLogController::class, 'getAuditLogs']);
});

