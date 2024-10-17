<?php

use App\Http\Controllers\admin\AboutController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\Admin\AmenitiesController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\OfferController;
use App\Http\Controllers\admin\SiteSettingController;
use App\Http\Controllers\admin\TermsController;
use App\Http\Controllers\admin\TypeController;
use App\Http\Controllers\frontend\HomePageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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


Route::get('/', [HomePageController::class, 'index'])->name('home');

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


    //Category Section
    Route::get('/amenities-section', [AmenitiesController::class, 'index'])->name('amenities.section');
    Route::post('/amenities-store', [AmenitiesController::class, 'store'])->name('amenities.store');
    Route::put('/amenities-update/{id}', [AmenitiesController::class, 'update'])->name('amenities.update');
    Route::get('/amenities-delete/{id}', [AmenitiesController::class, 'destroy'])->name('amenities.destroy');

    //Type Section
    Route::get('/type-section', [TypeController::class, 'index'])->name('type.section');
    Route::post('/type-store', [TypeController::class, 'store'])->name('type.store');
    Route::put('/type-update/{id}', [TypeController::class, 'update'])->name('type.update');
    Route::get('/type-delete/{id}', [TypeController::class, 'destroy'])->name('type.destroy');

    //Role and User Section
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    //Site Setting
    Route::get('/site-setting', [SiteSettingController::class, 'index'])->name('site.setting');
    Route::post('/site-settings-store-update/{id?}', [SiteSettingController::class, 'createOrUpdate'])->name('site-settings.createOrUpdate');
});

require __DIR__ . '/auth.php';
