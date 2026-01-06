<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\FunctionPositionController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\OrgStructureController;
use App\Http\Controllers\PositionTitleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MicrosoftAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\TableController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/auth/redirect', [MicrosoftAuthController::class, 'redirectToMicrosoft']);
Route::get('/connect', [MicrosoftAuthController::class, 'handleMicrosoftCallback']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/logout/{id}', [UserController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tables', [TableController::class, 'index']);
    Route::get('/tables/{table}/rows', [TableController::class, 'rows']);
    Route::post('/tables/{table}/rows', [TableController::class, 'store']);
});


Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('/position-titles', PositionTitleController::class);
    
    // User Controller
    Route::get('/get-user/{id}', [UserController::class, 'index']);

    // Function Position Controller
    Route::get('/description/{id}', [FunctionPositionController::class, 'getDescriptionById']);
    Route::post('/reorder-functions', [FunctionPositionController::class, 'reorderFunctions']);
    Route::post('/reorder-subfunctions', [FunctionPositionController::class, 'reorderSubfunctions']);
    Route::post('/reorder-descriptions', [FunctionPositionController::class, 'reorderDescriptions']);
    Route::get('/functions/{id}', [FunctionPositionController::class, 'getFunctionById']);
    Route::get('/subfunctions/{id}', [FunctionPositionController::class, 'getSubFunctionById']);
    Route::post('/manage-function', [FunctionPositionController::class, 'manageFunction']);
    Route::post('/manage-description', [FunctionPositionController::class, 'manageDescription']);
    Route::post('/delete-function', [FunctionPositionController::class, 'deleteFunction']);
    Route::get('/function-positions', [FunctionPositionController::class, 'index']);
    Route::get('/subfunction-dept/{dept}/{position?}', [FunctionPositionController::class, 'getSubfunctionDept']);
    Route::get('/function-positions/nested', [FunctionPositionController::class, 'nested']);

    // Organization Structure Controller
    Route::put('/organization-structure/update', [OrgStructureController::class, 'update']);
    Route::delete('/organization-structure/delete/{id}', [OrgStructureController::class, 'destroy']);
    Route::post('/organization-structure/add/{pid}', [OrgStructureController::class, 'store']);
    Route::get('/get-count-per-position', [OrgStructureController::class, 'getCountPerPosition']);
    Route::post('/upload-image', [OrgStructureController::class, 'uploadImage']);
    Route::get('/user-profile/{email}', [OrgStructureController::class, 'userProfile']);
    Route::get('/team-members/{id}', [OrgStructureController::class, 'teamMembers']);
    Route::get('/indirect-reporting/{id}', [OrgStructureController::class, 'indirectReporting']);
    Route::get('/get-head-count', [OrgStructureController::class, 'getHeadCount']);
    Route::get('/organization-structure', [OrgStructureController::class, 'index']);
    
    // Audit Log Controller
    Route::get('/functional-audit-logs', [AuditLogController::class, 'getFunctionalAuditLogs']);
    Route::get('/org-structure-audit-logs', [AuditLogController::class, 'getOrgStructureAuditLogs']);

    // My Profile Controller
    Route::post('/my-profile/store', [MyProfileController::class, 'store']);
    Route::get('/my-profile/download-pdf/{id}', [MyProfileController::class, 'exportPdf']);
    Route::get('/my-profile/edit/{id}', [MyProfileController::class, 'edit']);
    Route::get('/my-profile/{id}', [MyProfileController::class, 'show']);

    // About Controller (About Us Tab)
    Route::post('/about/upsert', [AboutController::class, 'upsert']);
    // Route::delete('/about/{org_structure_id}', [AboutController::class, 'destroyByProfileId']);
    Route::get('/about/edit/{id}', [AboutController::class, 'edit']);
    Route::get('/about/{id}', [AboutController::class, 'showByProfileId']);

    // Position Title Controller
});



