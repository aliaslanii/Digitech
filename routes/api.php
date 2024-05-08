<?php

use App\Http\Controllers\Api\Admin\Berand\BerandController;
use App\Http\Controllers\Api\Admin\Category\CategoryController;
use App\Http\Controllers\Api\Admin\Color\ColorController;
use App\Http\Controllers\Api\Admin\Locality\CityController;
use App\Http\Controllers\Api\Admin\Locality\StateController;
use App\Http\Controllers\Api\Admin\Product\ProductController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Home\User\UserControllerapi;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'userRegister']);
    Route::post('login', [AuthController::class, 'userLogin']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('detail', [AuthController::class, 'detail'])->middleware('role:Read');
        Route::get('logout', [AuthController::class, 'userLogout']);
    });
});
Route::prefix('User')->group(function () {
    Route::put('ChangePassword', [UserControllerapi::class, 'changePassword'])->middleware('auth:sanctum');
    Route::put('PersonalInformation', [UserControllerapi::class, 'personalInformation'])->middleware('auth:sanctum');
    Route::put('BankInformation', [UserControllerapi::class, 'bankInformation'])->middleware('auth:sanctum');
    Route::put('ChangeMobile', [UserControllerapi::class, 'changeMobile'])->middleware('auth:sanctum');
    Route::put('ChangeEmail', [UserControllerapi::class, 'changeEmail'])->middleware('auth:sanctum');
    Route::delete('destroy', [UserControllerapi::class, 'destroy']);
    Route::put('restore', [UserControllerapi::class, 'restore']);
});
Route::prefix('admin')->middleware('auth:sanctum','role:Admin')->group(function () {
    Route::prefix('Category')->group(function () {
        Route::get('index', [CategoryController::class, 'index'])->middleware('role:Read');
        Route::get('create', [CategoryController::class, 'create'])->middleware('role:Create');
        Route::post('store', [CategoryController::class, 'store'])->middleware('role:Create');
        Route::get('show', [CategoryController::class, 'show'])->middleware('role:Read');
        Route::get('edit', [CategoryController::class, 'edit'])->middleware('role:Update');
        Route::post('update', [CategoryController::class, 'update'])->middleware('role:Update');
        Route::delete('destroy', [CategoryController::class, 'destroy'])->middleware('role:Delete');
        Route::put('restore', [CategoryController::class, 'restore'])->middleware('role:Update');
    });
    Route::prefix('Berand')->group(function () {
        Route::get('index', [BerandController::class, 'index'])->middleware('role:Read');
        Route::get('create', [BerandController::class, 'create'])->middleware('role:Create');
        Route::post('store', [BerandController::class, 'store'])->middleware('role:Create');
        Route::get('show', [BerandController::class, 'show'])->middleware('role:Read');
        Route::get('edit', [BerandController::class, 'edit'])->middleware('role:Update');
        Route::post('update', [BerandController::class, 'update'])->middleware('role:Update');
        Route::delete('destroy', [BerandController::class, 'destroy'])->middleware('role:Delete');
        Route::put('restore', [BerandController::class, 'restore'])->middleware('role:Update');
    });
    Route::prefix('Color')->group(function () {
        Route::get('index', [ColorController::class, 'index'])->middleware('role:Read');
        Route::get('create', [ColorController::class, 'create'])->middleware('role:Create');
        Route::post('store', [ColorController::class, 'store'])->middleware('role:Create');
        Route::get('show', [ColorController::class, 'show'])->middleware('role:Read');
        Route::get('edit', [ColorController::class, 'edit'])->middleware('role:Update');
        Route::post('update', [ColorController::class, 'update'])->middleware('role:Update');
        Route::delete('destroy', [ColorController::class, 'destroy'])->middleware('role:Delete');
        Route::put('restore', [ColorController::class, 'restore'])->middleware('role:Update');
    });
    Route::prefix('State')->group(function () {
        Route::get('index', [StateController::class, 'index'])->middleware('role:Read');
        Route::get('create', [StateController::class, 'create'])->middleware('role:Create');
        Route::post('store', [StateController::class, 'store'])->middleware('role:Create');
        Route::get('show', [StateController::class, 'show'])->middleware('role:Read');
        Route::get('edit', [StateController::class, 'edit'])->middleware('role:Update');
        Route::post('update', [StateController::class, 'update'])->middleware('role:Update');
        Route::delete('destroy', [StateController::class, 'destroy'])->middleware('role:Delete');
        Route::put('restore', [StateController::class, 'restore'])->middleware('role:Update');
    });
    Route::prefix('City')->group(function () {
        Route::get('index', [CityController::class, 'index'])->middleware('role:Read');
        Route::get('create', [CityController::class, 'create'])->middleware('role:Create');
        Route::post('store', [CityController::class, 'store'])->middleware('role:Create');
        Route::get('show', [CityController::class, 'show'])->middleware('role:Read');
        Route::get('edit', [CityController::class, 'edit'])->middleware('role:Update');
        Route::post('update', [CityController::class, 'update'])->middleware('role:Update');
        Route::delete('destroy', [CityController::class, 'destroy'])->middleware('role:Delete');
        Route::put('restore', [CityController::class, 'restore'])->middleware('role:Update');
    });
    Route::prefix('Product')->group(function () {
        Route::get('index', [ProductController::class, 'index'])->middleware('role:Read');
        Route::get('create', [ProductController::class, 'create'])->middleware('role:Create');
        Route::post('store', [ProductController::class, 'store'])->middleware('role:Create');
        Route::get('show', [ProductController::class, 'show'])->middleware('role:Read');
        Route::get('edit', [ProductController::class, 'edit'])->middleware('role:Update');
        Route::post('update', [ProductController::class, 'update'])->middleware('role:Update');
        Route::delete('destroy', [ProductController::class, 'destroy'])->middleware('role:Delete');
        Route::put('restore', [ProductController::class, 'restore'])->middleware('role:Update');
        Route::post('add/Color/Price', [ProductController::class, 'addProductColorPrice'])->middleware('role:Create');
        Route::post('update/Color/Price', [ProductController::class, 'updateProductColorPrice'])->middleware('role:Create');
        Route::post('add/Detial', [ProductController::class, 'addProductDetial'])->middleware('role:Create');
        Route::post('update/Detial', [ProductController::class, 'updateProductDetial'])->middleware('role:Create');
        Route::post('add/image', [ProductController::class, 'addProductImage'])->middleware('role:Create');
        Route::delete('remove/image', [ProductController::class, 'removeProductImage'])->middleware('role:Delete');
    });
});