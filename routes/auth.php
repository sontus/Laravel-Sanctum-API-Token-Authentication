<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login',[LoginController::class,'__invoke']);
Route::post('register',[RegisterController::class,'__invoke']);
Route::post('password/email',[PasswordResetController::class,'sendResetLinkEmail']);
Route::post('password/reset',[PasswordResetController::class,'resetPassword'])->middleware('signed')->name('password.reset');

Route::get('unauthorized', function () {
    return response()->json(['message' => 'Unauthorized.'], 401);
});
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user',[UserController::class,'__invoke']);
    Route::post('/logout', [LogoutController::class, '__invoke']);

});
