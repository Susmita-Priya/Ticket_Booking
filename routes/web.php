<?php

use App\Http\Controllers\admin\AboutController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AmenitiesController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\CuponController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\Journey_typeController;
use App\Http\Controllers\admin\LocationController;
use App\Http\Controllers\admin\OfferController;
use App\Http\Controllers\admin\PlaneController;
use App\Http\Controllers\admin\PlaneJourneyController;
use App\Http\Controllers\admin\SeatController;
use App\Http\Controllers\admin\SiteSettingController;
use App\Http\Controllers\admin\TermsController;
use App\Http\Controllers\admin\TypeController;
use App\Http\Controllers\admin\VehicleController;
use App\Http\Controllers\frontend\HomePageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


//Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/about', [HomePageController::class, 'about'])->name('about');

Route::get('/offer', [HomePageController::class, 'offer'])->name('offer');
Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');

Route::middleware('auth')->group(callback: function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/unauthorized-action', [AdminDashboardController::class, 'unauthorized'])->name('unauthorized.action');

    //About Section
    Route::get('/about-section', [AboutController::class, 'index'])->name('about.section');
    Route::post('/about-store', [AboutController::class, 'store'])->name('about.store');
    Route::put('/about-update/{id}', [AboutController::class, 'update'])->name('about.update');
    Route::get('/about-delete/{id}', [AboutController::class, 'destroy'])->name('about.destroy');

    //Faq Section
    Route::get('/faq-section', [FaqController::class, 'index'])->name('faq.section');
    Route::post('/faq-store', [FaqController::class, 'store'])->name('faq.store');
    Route::put('/faq-update/{id}', [FaqController::class, 'update'])->name('faq.update');
    Route::get('/faq-delete/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');

    //offer Section
    Route::get('/offer-section', [OfferController::class, 'index'])->name('offer.section');
    Route::post('/offer-store', [OfferController::class, 'store'])->name('offer.store');
    Route::put('/offer-update/{id}', [OfferController::class, 'update'])->name('offer.update');
    Route::get('/offer-delete/{id}', [OfferController::class, 'destroy'])->name('offer.destroy');

    //terms Section
    Route::get('/terms-section', [TermsController::class, 'index'])->name('terms.section');
    Route::post('/terms-store', [TermsController::class, 'store'])->name('terms.store');
    Route::put('/terms-update/{id}', [TermsController::class, 'update'])->name('terms.update');
    Route::get('/terms-delete/{id}', [TermsController::class, 'destroy'])->name('terms.destroy');

    //Category Section
    Route::get('/category-section', [CategoryController::class, 'index'])->name('category.section');
    Route::post('/category-store', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category-update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category-delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    //Amenities Section
    Route::get('/amenities-section', [AmenitiesController::class, 'index'])->name('amenities.section');
    Route::post('/amenities-store', [AmenitiesController::class, 'store'])->name('amenities.store');
    Route::put('/amenities-update/{id}', [AmenitiesController::class, 'update'])->name('amenities.update');
    Route::get('/amenities-delete/{id}', [AmenitiesController::class, 'destroy'])->name('amenities.destroy');

    //Vehicle Section
    Route::get('/vehicle-section', [VehicleController::class, 'index'])->name('vehicle.section');
    Route::post('/vehicle-store', [VehicleController::class, 'store'])->name('vehicle.store');
    Route::put('/vehicle-update/{id}', [VehicleController::class, 'update'])->name('vehicle.update');
    Route::get('/vehicle-delete/{id}', [VehicleController::class, 'destroy'])->name('vehicle.destroy');

    //Seat Section
    Route::get('/seats-section/{vehicle_id}', [SeatController::class, 'index'])->name('seats.section');
    Route::post('/seats-store', [SeatController::class, 'store'])->name('seats.store');
    Route::put('/seats-update/{id}', [SeatController::class, 'update'])->name('seats.update');
    Route::get('/seats-delete/{id}', [SeatController::class, 'destroy'])->name('seats.destroy');

    //Country Section
    Route::get('/country-section', [CountryController::class, 'index'])->name('country.section');
    Route::post('/country-store', [CountryController::class, 'store'])->name('country.store');
    Route::put('/country-update/{id}', [CountryController::class, 'update'])->name('country.update');
    Route::get('/country-delete/{id}', [CountryController::class, 'destroy'])->name('country.destroy');

    //Location Section
    Route::get('/location-section', [LocationController::class, 'index'])->name('location.section');
    Route::post('/location-store', [LocationController::class, 'store'])->name('location.store');
    Route::put('/location-update/{id}', [LocationController::class, 'update'])->name('location.update');
    Route::get('/location-delete/{id}', [LocationController::class, 'destroy'])->name('location.destroy');

    //Type Section
    Route::get('/type-section', [TypeController::class, 'index'])->name('type.section');
    Route::post('/type-store', [TypeController::class, 'store'])->name('type.store');
    Route::put('/type-update/{id}', [TypeController::class, 'update'])->name('type.update');
    Route::get('/type-delete/{id}', [TypeController::class, 'destroy'])->name('type.destroy');

    //Journey Type Section
    Route::get('/journey-type-section', [Journey_typeController::class, 'index'])->name('journey_type.section');
    Route::post('/journey-type-store', [Journey_typeController::class, 'store'])->name('journey_type.store');
    Route::put('/journey-type-update/{id}', [Journey_typeController::class, 'update'])->name('journey_type.update');
    Route::get('/journey-type-delete/{id}', [Journey_typeController::class, 'destroy'])->name('journey_type.destroy');

    //Cupon Section
    Route::get('/cupon-section', [CuponController::class, 'index'])->name('cupon.section');
    Route::post('/cupon-store', [CuponController::class, 'store'])->name('cupon.store');
    Route::put('/cupon-update/{id}', [CuponController::class, 'update'])->name('cupon.update');
    Route::get('/cupon-delete/{id}', [CuponController::class, 'destroy'])->name('cupon.destroy');

    //plane Section
    Route::get('/plane-section', [PlaneController::class, 'index'])->name('plane.section');
    Route::post('/plane-store', [PlaneController::class, 'store'])->name('plane.store');
    Route::put('/plane-update/{id}', [PlaneController::class, 'update'])->name('plane.update');
    Route::get('/plane-delete/{id}', [PlaneController::class, 'destroy'])->name('plane.destroy');


    //Plane Journey Section
    Route::get('/plane-journey-section', [PlaneJourneyController::class, 'index'])->name('plane_journey.section');
    Route::post('/plane-journey-store', [PlaneJourneyController::class, 'store'])->name('plane_journey.store');
    Route::put('/plane-journey-update/{id}', [PlaneJourneyController::class, 'update'])->name('plane_journey.update');
    Route::get('/plane-journey-delete/{id}', [PlaneJourneyController::class, 'destroy'])->name('plane_journey.destroy');


    // country and location
    Route::get('/countries/{id}/locations', [PlaneJourneyController::class, 'getlocation'])->name('plane.getlocation');


    //Role and User Section
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    //Site Setting
    Route::get('/site-setting', [SiteSettingController::class, 'index'])->name('site.setting');
    Route::post('/site-settings-store-update/{id?}', [SiteSettingController::class, 'createOrUpdate'])->name('site-settings.createOrUpdate');
});

require __DIR__ . '/auth.php';
