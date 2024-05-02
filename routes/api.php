<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserControllerapi;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'userRegister']);
    Route::post('login', [AuthController::class, 'userLogin']);
    Route::middleware(['auth:sanctum'])->group(function() {
        Route::get('detail', [AuthController::class, 'detail'])->middleware('role:Read');
        Route::get('logout', [AuthController::class, 'userLogout']);
    });
});
Route::prefix('User')->group(function(){
    Route::put('ChangePassword', [UserControllerapi::class,'changePassword'])->middleware('auth:sanctum');
    Route::put('PersonalInformation', [UserControllerapi::class,'personalInformation'])->middleware('auth:sanctum');
    Route::put('BankInformation', [UserControllerapi::class,'bankInformation'])->middleware('auth:sanctum');
    Route::put('ChangeMobile', [UserControllerapi::class,'changeMobile'])->middleware('auth:sanctum');
    Route::put('ChangeEmail', [UserControllerapi::class,'changeEmail'])->middleware('auth:sanctum');
    Route::delete('destroy', [UserControllerapi::class,'destroy']);
    Route::put('restore', [UserControllerapi::class,'restore']);
});

