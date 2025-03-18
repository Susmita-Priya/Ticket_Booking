<?php

use App\Http\Controllers\api\SliderController;
use App\Http\Controllers\api\TypeController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\CuponController;
use App\Http\Controllers\api\LocationController;
use App\Http\Controllers\api\PassengerController;
use App\Http\Controllers\api\PlaneController;
use App\Http\Controllers\api\SearchController;
use App\Http\Controllers\api\TicketBookingController;
use App\Http\Controllers\api\UserController;
use App\Models\TicketBooking;
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

//type 
Route::get('/type', [TypeController::class, 'type']);

//location
Route::get('/location-bus', [LocationController::class, 'locationBus']);

//search bus
Route::post('/search-bus', [SearchController::class, 'searchBus']);

//slider
Route::get('/slider', [SliderController::class, 'index']);

//user info
Route::middleware('auth:sanctum')->group(function () {

    //user info
    Route::get('/user-info', [UserController::class, 'userInfo']);

    //update password
    Route::post('/update-password', [UserController::class, 'updatePassword']);

    //logout
    Route::post('/logout', [UserController::class, 'logout']);

    //booking bus
    Route::post('/ticket-booking', [TicketBookingController::class, 'storeBooking']);

    //get booking bus
    Route::get('/ticket-booking-list', [TicketBookingController::class, 'booking']);



    //Passenger routes plane
    Route::post('/store-passenger', [PassengerController::class, 'storePassenger']);

    // Booking routes plane
    Route::post('/store-booking', [BookingController::class, 'storeBooking']);
    
    //booking plane
    Route::get('/booking', [BookingController::class, 'booking']);

});


// Define Cupon routes
Route::get('/cupon', [CuponController::class, 'cupon']);

// Plane routes
Route::get('/plane', [PlaneController::class, 'plane']);

// search routes
Route::post('/search-plane', [SearchController::class, 'searchPlane']);

// location routes
Route::get('/location-plane', [LocationController::class, 'locationPlane']);
