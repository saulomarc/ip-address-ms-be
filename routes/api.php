<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IpAddressController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('save-password', [AuthController::class, 'savePassword']);
Route::post('logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth:api'], 'prefix' => 'auth'], function () {    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('test', [AuthController::class, 'test']);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResource('ip-addresses', IpAddressController::class);
});

Route::group(['middleware' => ['auth:api', 'role:super_admin'], 'prefix' => 'super-admin'], function () {
    Route::get('user-sessions', [AuditLogController::class, 'fetchUserSessions']);
    Route::get('ip-addresses', [AuditLogController::class, 'fetchIpAddressLogs']);
});