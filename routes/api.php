<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DeviceStatusController;
use App\Http\Controllers\DeviceTriggerController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AccountManagementController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DeviceInstructionController;
use App\Http\Controllers\RelayController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/me', [AuthenticationController::class, 'me']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware('pemilik-postingan');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('pemilik-postingan');

    Route::post('/comment', [CommentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware('pemilik-comentar');
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->middleware('pemilik-comentar');
    Route::post('/relay/open', [RelayController::class, 'openRelay']);
    Route::post('/relay/close', [RelayController::class, 'closeRelay']);
    Route::post('/relay/add', [RelayController::class, 'addDevice']); 
    Route::get('/relay/devices', [RelayController::class, 'getDevices']);
    Route::get('/relay/logs', [RelayController::class, 'getAllDeviceLogs']);
    Route::post('/relay/devices/delete', [RelayController::class, 'deleteDevice']);


});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('register', [AuthenticationController::class, 'register']);
Route::get('verify/{id}', [AuthenticationController::class, 'verifyEmail']);

Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail']);

Route::post('/register-master', [AuthenticationController::class, 'registerMaster']);

Route::middleware(['auth:sanctum', 'role:master'])->group(function () {
    Route::post('/add-child-account', [AccountManagementController::class, 'addChildAccount']);
    Route::get('/child-accounts', [AccountManagementController::class, 'getChildAccounts']);
    Route::post('/delete-child-account/{id}', [AccountManagementController::class, 'deleteChildAccount']);
});

Route::post('/control-door', [AccountManagementController::class, 'controlDoorFromArduino']);

// New routes for device management

Route::get('/relay/all-devices', [RelayController::class, 'getAllDevices']);

// Route to update status from NodeMCU
Route::get('/get-instruction/{serial_number}', [RelayController::class, 'getRelayStatus']);

// New routes for device instructions


// New routes for relay control
