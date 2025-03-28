<?php

use App\Http\Controllers\admin\AboutController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AmenitiesController;
use App\Http\Controllers\admin\BookingController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CheckerController;
use App\Http\Controllers\admin\CounterController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\CuponController;
use App\Http\Controllers\admin\DistrictController;
use App\Http\Controllers\admin\DivisionController;
use App\Http\Controllers\admin\DriverController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\Journey_typeController;
use App\Http\Controllers\admin\JourneyTypeController;
use App\Http\Controllers\admin\LocationController;
use App\Http\Controllers\admin\OfferController;
use App\Http\Controllers\admin\OwnerController;
use App\Http\Controllers\admin\PlaneController;
use App\Http\Controllers\admin\PlaneJourneyController;
use App\Http\Controllers\admin\PublishedVehicleController;
use App\Http\Controllers\admin\RouteController;
use App\Http\Controllers\admin\RouteManagerController;
use App\Http\Controllers\admin\SeatBookingController;
use App\Http\Controllers\admin\SeatController;
use App\Http\Controllers\admin\SiteSettingController;
use App\Http\Controllers\admin\SupervisorController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\completedTripController;
use App\Http\Controllers\admin\employeeController;
use App\Http\Controllers\admin\ExpenseController;
use App\Http\Controllers\admin\HelperController;
use App\Http\Controllers\admin\IncomeController;
use App\Http\Controllers\admin\PDFController;
use App\Http\Controllers\admin\PlaceController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\TermsController;
use App\Http\Controllers\admin\testHelper;
use App\Http\Controllers\admin\testHelperController;
use App\Http\Controllers\admin\TicketBookingController;
use App\Http\Controllers\admin\TripController;
use App\Http\Controllers\admin\TypeController;
use App\Http\Controllers\admin\VehicleController;
use App\Http\Controllers\frontend\HomePageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Expense;
use App\Models\SeatBooking;
use App\Models\TicketBooking;
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


Route::get('/medicine-app-prototype', function () {
    return view('medicine-panda-design');
});


//Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/about', [HomePageController::class, 'about'])->name('about');

Route::get('/offer', [HomePageController::class, 'offer'])->name('offer');
Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');

Route::middleware('auth')->group(callback: function () {

    // Route::get('/test', [testHelperController::class, 'index']);
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
    Route::get('/seats-section/{vehicle_id?}', [SeatController::class, 'index'])->name('seats.section');
    Route::post('/seats-store', [SeatController::class, 'store'])->name('seats.store');
    Route::put('/seats-update/{id}', [SeatController::class, 'update'])->name('seats.update');
    Route::put('/seat-select', [SeatController::class, 'selectSeat'])->name('seats.select');
    Route::get('/seats-delete/{id}', [SeatController::class, 'destroy'])->name('seats.destroy');

    // reset seat
    Route::get('/reset-seat/{vehicle_id}', [SeatController::class, 'resetSeat'])->name('reset.seat');

    // Ticket booking
    Route::get('/ticket-booking-section', [TicketBookingController::class, 'index'])->name('ticket_booking.section');
    Route::post('/ticket-booking-store', [TicketBookingController::class, 'store'])->name('ticket_booking.store');
    Route::get('/ticket-booking/passenger-details', [TicketBookingController::class, 'showDetails'])->name('passenger.detail');
    Route::post('/reserve-seats', [TicketBookingController::class, 'reserveSeats'])->name('reserve.seats');
    Route::post('/cancel/reservation', [TicketBookingController::class, 'cancelReservation'])->name('cancel.reservation');
    Route::get('/booking-confirmation', [TicketBookingController::class, 'showConfirmation'])->name('booking.confirmation');
    Route::get('/generate-pdf/{id}', [TicketBookingController::class, 'generatePDF'])->name('generate.pdf');


    //Seat Booking Section after ticket booking done
    Route::get('/seat-booking-section', [SeatBookingController::class, 'index'])->name('seat_booking.section');
    Route::get('/seat-booking-delete/{id}', [SeatBookingController::class, 'destroy'])->name('seat_booking.destroy');


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
    Route::get('/journey-type-section', [JourneyTypeController::class, 'index'])->name('journey_type.section');
    Route::post('/journey-type-store', [JourneyTypeController::class, 'store'])->name('journey_type.store');
    Route::put('/journey-type-update/{id}', [JourneyTypeController::class, 'update'])->name('journey_type.update');
    Route::get('/journey-type-delete/{id}', [JourneyTypeController::class, 'destroy'])->name('journey_type.destroy');

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


    //booking Section
    Route::get('/booking-section', [BookingController::class, 'index'])->name('booking.section');
    Route::get('/booking-delete/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');


    //Role and User Section
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/show/users/{id}', [UserController::class, 'fetch']);

    //Site Setting
    Route::get('/site-setting', [SiteSettingController::class, 'index'])->name('site.setting');
    Route::post('/site-settings-store-update/{company_id?}', [SiteSettingController::class, 'createOrUpdate'])->name('site-settings.createOrUpdate');


    //Division Section
    Route::get('/division-section', [DivisionController::class, 'index'])->name('division.section');
    Route::post('/division-store', [DivisionController::class, 'store'])->name('division.store');
    Route::put('/division-update/{id}', [DivisionController::class, 'update'])->name('division.update');
    Route::get('/division-delete/{id}', [DivisionController::class, 'destroy'])->name('division.destroy');

    //District Section
    Route::get('/district-section', [DistrictController::class, 'index'])->name('district.section');
    Route::post('/district-store', [DistrictController::class, 'store'])->name('district.store');
    Route::put('/district-update/{id}', [DistrictController::class, 'update'])->name('district.update');
    Route::get('/district-delete/{id}', [DistrictController::class, 'destroy'])->name('district.destroy');

    //Place Section
    Route::get('/place-section', [PlaceController::class, 'index'])->name('place.section');
    Route::post('/place-store', [PlaceController::class, 'store'])->name('place.store');
    Route::put('/place-update/{id}', [PlaceController::class, 'update'])->name('place.update');
    Route::get('/place-delete/{id}', [PlaceController::class, 'destroy'])->name('place.destroy');


    //counter
    Route::get('/counter-section', [CounterController::class, 'index'])->name('counter.section');
    Route::post('/counter-store', [CounterController::class, 'store'])->name('counter.store');
    Route::put('/counter-update/{id}', [CounterController::class, 'update'])->name('counter.update');
    Route::get('/counter-delete/{id}', [CounterController::class, 'destroy'])->name('counter.destroy');


    //employee
    Route::get('/employee-section', [employeeController::class, 'index'])->name('employee.section');
    Route::post('/employee-store', [employeeController::class, 'store'])->name('employee.store');
    Route::put('/employee-update/{id}', [employeeController::class, 'update'])->name('employee.update');
    Route::get('/employee-delete/{id}', [employeeController::class, 'destroy'])->name('employee.destroy');


    // //RouteManager
    // Route::get('/routeManager-section', [RouteManagerController::class, 'index'])->name('routeManager.section');
    // Route::post('/routeManager-store', [RouteManagerController::class, 'store'])->name('routeManager.store');
    // Route::put('/routeManager-update/{id}', [RouteManagerController::class, 'update'])->name('routeManager.update');
    // Route::get('/routeManager-delete/{id}', [RouteManagerController::class, 'destroy'])->name('routeManager.destroy');


    // //checker
    // Route::get('/checker-section', [CheckerController::class, 'index'])->name('checker.section');
    // Route::post('/checker-store', [CheckerController::class, 'store'])->name('checker.store');
    // Route::put('/checker-update/{id}', [CheckerController::class, 'update'])->name('checker.update');
    // Route::get('/checker-delete/{id}', [CheckerController::class, 'destroy'])->name('checker.destroy');


    // //owner
    // Route::get('/owner-section', [OwnerController::class, 'index'])->name('owner.section');
    // Route::post('/owner-store', [OwnerController::class, 'store'])->name('owner.store');
    // Route::put('/owner-update/{id}', [OwnerController::class, 'update'])->name('owner.update');
    // Route::get('/owner-delete/{id}', [OwnerController::class, 'destroy'])->name('owner.destroy');


    // //driver
    // Route::get('/driver-section', [DriverController::class, 'index'])->name('driver.section');
    // Route::post('/driver-store', [DriverController::class, 'store'])->name('driver.store');
    // Route::put('/driver-update/{id}', [DriverController::class, 'update'])->name('driver.update');
    // Route::get('/driver-delete/{id}', [DriverController::class, 'destroy'])->name('driver.destroy');


    // //helper
    // Route::get('/helper-section', [HelperController::class, 'index'])->name('helper.section');
    // Route::post('/helper-store', [HelperController::class, 'store'])->name('helper.store');
    // Route::put('/helper-update/{id}', [HelperController::class, 'update'])->name('helper.update');
    // Route::get('/helper-delete/{id}', [HelperController::class, 'destroy'])->name('helper.destroy');    


    // //supervisor
    // Route::get('/supervisor-section', [SupervisorController::class, 'index'])->name('supervisor.section');
    // Route::post('/supervisor-store', [SupervisorController::class, 'store'])->name('supervisor.store');
    // Route::put('/supervisor-update/{id}', [SupervisorController::class, 'update'])->name('supervisor.update');
    // Route::get('/supervisor-delete/{id}', [SupervisorController::class, 'destroy'])->name('supervisor.destroy');


    //route
    Route::get('/route-section', [RouteController::class, 'index'])->name('route.section');
    Route::get('/location/{id}/counters', [RouteController::class, 'getCounter'])->name('route.getcounter');
    Route::post('/route-store', [RouteController::class, 'store'])->name('route.store');
    Route::put('/route-update/{id}', [RouteController::class, 'update'])->name('route.update');
    Route::get('/route-info-delete/{id}', [RouteController::class, 'destroy'])->name('route.destroy');


    //Trip
    Route::get('/trip-section', [TripController::class, 'index'])->name('trip.section');
    Route::post('/trip-store', [TripController::class, 'store'])->name('trip.store');
    Route::put('/trip-update/{id}', [TripController::class, 'update'])->name('trip.update');
    Route::get('/trip-delete/{id}', [TripController::class, 'destroy'])->name('trip.destroy');

    Route::get('/fetch-vehicles', [TripController::class, 'fetchVehicles']);

    //Completed Trip
    Route::get('/completed-trip-section', [completedTripController::class, 'index'])->name('completed.trip.section');


    //Accounting Section Expense
    Route::get('/expense-section', [ExpenseController::class, 'index'])->name('expense.section');
    Route::post('/expense-store', [ExpenseController::class, 'store'])->name('expense.store');
    Route::put('/expense-update/{id}', [ExpenseController::class, 'update'])->name('expense.update');
    Route::get('/expense-delete/{id}', [ExpenseController::class, 'destroy'])->name('expense.destroy');
    Route::get('/deleted-expense-section', [ExpenseController::class, 'deletedExpense'])->name('deleted.expense.section');
    Route::post('/expense-restore/{id}', [ExpenseController::class, 'restore'])->name('expense.restore');
    Route::delete('/expense-force-delete/{id}', [ExpenseController::class, 'forceDelete'])->name('expense.forceDelete');
    Route::get('/expenses/pdf', [ExpenseController::class, 'downloadPDF'])->name('expenses.pdf');
    
    // Route::view('/expen/pdf', 'admin.pages.expense.pdf');

    // Get types and employees based on department
    Route::get('/get-employee', [ExpenseController::class, 'getTypeEmployee'])->name('get.type.employee');

    //Income Section
    Route::get('/income-section', [IncomeController::class, 'index'])->name('income.section');
    Route::get('/income/pdf', [IncomeController::class, 'downloadPDF'])->name('income.pdf');

    Route::get('/get-vehicles', [IncomeController::class, 'getVehicles'])->name('get.vehicles');

    //slider
    Route::get('/slider-section', [SliderController::class, 'index'])->name('slider.section');
    Route::post('/slider-store', [SliderController::class, 'store'])->name('slider.store');
    Route::put('/slider-update/{id}', [SliderController::class, 'update'])->name('slider.update');
    Route::get('/slider-delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');


    //Blog
    Route::get('/blog-section', [BlogController::class, 'index'])->name('blog.section');
    Route::post('/blog-store', [BlogController::class, 'store'])->name('blog.store');
    Route::put('/blog-update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::get('/blog-delete/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');

    //service
    Route::get('/service-section', [ServiceController::class, 'index'])->name('service.section');
    Route::post('/service-store', [ServiceController::class, 'store'])->name('service.store');
    Route::put('/service-update/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::get('/service-delete/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
});

require __DIR__ . '/auth.php';
