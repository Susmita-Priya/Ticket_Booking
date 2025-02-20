<?php

use App\Http\Controllers\api\TypeController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\CuponController;
use App\Http\Controllers\api\LocationController;
use App\Http\Controllers\api\PassengerController;
use App\Http\Controllers\api\PlaneController;
use App\Http\Controllers\api\SearchController;
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
Route::post('/user-registration', [UserController::class, 'register']);
Route::post('/verify', [UserController::class, 'verify']);
Route::post('/resend-verification-code', [UserController::class, 'resendVerificationCode']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/forgot-password', [UserController::class, 'forgotPassword']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);


//user info
Route::middleware('auth:sanctum')->group(function () {

    //user info
    Route::get('/user-info', [UserController::class, 'userInfo']);

    //update password
    Route::post('/update-password', [UserController::class, 'updatePassword']);

    //logout
    Route::post('/logout', [UserController::class, 'logout']);

    //Passenger routes
    Route::post('/store-passenger', [PassengerController::class, 'storePassenger']);

    // Booking routes
    Route::post('/store-booking', [BookingController::class, 'storeBooking']);
    
    //booking
    Route::get('/booking', [BookingController::class, 'booking']);

    //type 
    Route::get('/type', [TypeController::class, 'type']);
});


// Define Cupon routes
Route::get('/cupon', [CuponController::class, 'cupon']);

// Plane routes
Route::get('/plane', [PlaneController::class, 'plane']);

// search routes
Route::post('/search', [SearchController::class, 'search']);

// location routes
Route::get('/location', [LocationController::class, 'location']);
