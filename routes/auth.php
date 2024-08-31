<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login',[LoginController::class,'__invoke']);
Route::post('register',[RegisterController::class,'__invoke']);
Route::post('password/email',[PasswordResetController::class,'sendResetLinkEmail']);
Route::post('password/reset',[PasswordResetController::class,'resetPassword'])->middleware('signed')->name('password.reset');

Route::group(['middleware' => 'auth:sanctum',], function () {
    Route::post('email/verify/send',[VerifyEmailController::class,'sendMail'])->name('verification.send');
    Route::post('email/verify',[VerifyEmailController::class,'verifyEmail'])->middleware('signed')->name('verification.verify');
    Route::post('email/verify/resend',[VerifyEmailController::class,'resendVerificationEmail']);
    Route::post('/logout', [LogoutController::class, '__invoke']);
});

Route::group(['middleware' => 'auth:sanctum,verified',], function () {
    Route::get('/user',[UserController::class,'__invoke']);
});

Route::get('unauthorized', function () {
    return response()->json(['message' => 'Unauthorized.'], 401);
});
