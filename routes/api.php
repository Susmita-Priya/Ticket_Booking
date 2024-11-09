<?php

use App\Http\Controllers\api\CuponController;
use App\Http\Controllers\api\PassengerController;
use App\Http\Controllers\api\PlaneController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// User routes
Route::post('/user-registration', [UserController::class, 'storeRegistration']);
Route::post('/verify', [UserController::class, 'verify']);
Route::post('/login', [UserController::class, 'login']);

//user info
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user-info', [UserController::class, 'userInfo']);
    Route::post('/store-passenger', [PassengerController::class, 'storePassenger']);

});

// Define Cupon routes
Route::get('/cupon', [CuponController::class, 'cupon']);


// Plane routes
Route::get('/plane', [PlaneController::class, 'plane']);


// Passenger routes


