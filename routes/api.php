<?php

use App\Http\Controllers\api\CuponController;
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

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/getuserinfo', [UserController::class, 'getinfo']);

});


// Cupon routes
Route::get('/cupon', [CuponController::class, 'cupon']);


// Plane routes
Route::get('/plane', [PlaneController::class, 'plane']);


