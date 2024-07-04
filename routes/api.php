<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/logout',[AuthenticationController::class, 'logout']);
    Route::get('/me',[AuthenticationController::class, 'me']);
    Route::post('/posts',[PostController::class, 'store']);
    Route::patch('/posts/{id}',[PostController::class, 'update'])->middleware('pemilik-postingan');
    Route::delete('/posts/{id}',[PostController::class, 'destroy'])->middleware('pemilik-postingan');


    Route::post('/comment',[CommentController::class, 'store']);
    Route::patch('/comment/{id}',[CommentController::class, 'update'])->middleware('pemilik-comentar');
    Route::delete('/comment/{id}',[CommentController::class, 'destroy'])->middleware('pemilik-comentar');

});

Route::get('/posts',[PostController::class,'index']);
Route::get('/posts/{id}',[PostController::class,'show']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('register', [AuthenticationController::class, 'register']);
Route::get('verify/{id}', [AuthenticationController::class, 'verifyEmail']);

Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail']);



