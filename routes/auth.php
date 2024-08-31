<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login',[LoginController::class,'__invoke']);
Route::get('unauthorized', function () {
    return response()->json(['message' => 'Unauthorized.'], 401);
});
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {return $request->user();});

    Route::post('/logout', [LogoutController::class, '__invoke']);
});
