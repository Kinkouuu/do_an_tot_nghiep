<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\User\RoomController;
use App\Http\Controllers\User\UserPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//User Page
Route::get('/', [UserPageController::class, 'index'])->name('homepage');
Route::get('/introduce', [UserPageController::class, 'introduce'])->name('introduce');
Route::get('/contact', [UserPageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'sendContact']);

//Authentication
Route::get('/sign-up', [UserPageController::class, 'signup'])->name('signup');
Route::get('/log-in', [UserPageController::class, 'login'])->name('login');

Route::post('/sign-up', [AuthController::class, 'register'])->name('register');
Route::post('/log-in', [AuthController::class, 'signin'])->name('signin');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/send-verify-code/{code}', [AuthController::class, 'sendVerifyCode'])->name('send_verify_code');
//Room & Branch
Route::get('/search', [UserPageController::class,'search'])->name('search');

Route::get('/room-type/{roomType}', [RoomController::class,'getRoomType'])->name('room-type');
//User Account
Route::get('/verify-code', [UserPageController::class, 'verifyCode'])->name('verify_code');
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::get('/re-active-account', [UserPageController::class, 'reActiveAccount'])->name('re_active_account');
Route::get('/forgot-password', [UserPageController::class, 'forgotPassword'])->name('forgot_password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::middleware(['forgotPassword'])->group(function () {
    Route::get('/change-password', [UserPageController::class, 'changePassword'])->name('change_password');
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/personal-information', [CustomerController::class, 'getUserInfo'])->name('get-user-info');
    Route::post('/personal-information', [CustomerController::class, 'updateUserInfo'])->name('update-user-info');
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/confirm', [BookingController::class, 'bookingConfirm'])->name('confirm');
        Route::post('/confirm', [BookingController::class, 'store'])->name('booking');
        Route::get('/', [BookingController::class, 'index'])->name('list');
        Route::get('/payment-response/{bookingId}', [BookingController::class, 'showPaymentResponse'])->name('payment-response');
        Route::get('/{bookingId}', [BookingController::class, 'show'])->name('show');
        Route::get('/payment-request/{bookingId}', [BookingController::class, 'bookingPayment'])->name('payment-request');
        Route::post('/{id}/cancel', [BookingController::class, 'bookingCancel'])->name('cancel');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    //Admin authentication
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'signin']);
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    /*Middleware STAFF*/
    Route::middleware('staffs')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        //Customer manager
        Route::resource('customers', AdminCustomerController::class);
        //User manager
        Route::resource('users', AdminUserController::class);
        //Device Manager
        Route::resource('devices', DeviceController::class);
        //GET room type
        Route::get('room-type', [RoomTypeController::class, 'index'])->name('room-type.index');
        Route::get('room-type/images/{code}', [RoomTypeController::class, 'getImages'])->name('room-type.images');
        Route::get('room-type/services/{code}', [RoomTypeController::class, 'getServices'])->name('room-type.services');
        //Booking manager
        Route::resource('booking',AdminBookingController::class);
        Route::prefix('booking')->name('booking.')->group(function () {
            Route::post('/{booking}/refuse', [AdminBookingController::class, 'refuseBooking'])->name('refuse');
            Route::post('/choose-room', [AdminBookingController::class, 'chooseRoom'])->name('choose-room');
            Route::post('/{booking}/complete', [AdminBookingController::class, 'completeBooking'])->name('complete');
            Route::get('/{booking}/print-invoice', [AdminBookingController::class, 'createInvoice'])->name('invoice-create');
        });
        /*Middleware MANAGER*/
        Route::middleware('manager')->group(function () {
            //Room type manager
            Route::prefix('room-type')->name('room-type.')->group(function () {
                Route::post('images/{typeRoom}/change-thumb', [RoomTypeController::class, 'changeThumbNail'])->name('images.thumb');
                Route::delete('images/{roomImage}', [RoomTypeController::class, 'deleteImage'])->name('images.delete');
                Route::post('images/{typeRoom}/change-detail', [RoomTypeController::class, 'changeDetail'])->name('images.detail');
                Route::post('services/{typeRoom}/add', [RoomTypeController::class, 'addServices'])->name('services.add');
                Route::post('services/{typeRoom}/remove', [RoomTypeController::class, 'removeServices'])->name('services.remove');
                Route::post('services/{typeRoom}', [RoomTypeController::class, 'addServices'])->name('services.add');
            });
            //Room manager
            Route::resource('room',AdminRoomController::class);
            Route::prefix('room')->name('room.')->group(function () {
                Route::get('{code}/devices', [AdminRoomController::class, 'getDevices'])->name('devices');
            });
        });

        /*Middleware ADMIN*/
        Route::middleware('admin')->group(function () {
            //Staff Manager
            Route::resource('staffs', StaffController::class);
            Route::post('staffs/reset-password/{staff}', [StaffController::class, 'resetPassword'])->name('staffs.reset-password');
            //Service Manager
            Route::resource('services', ServiceController::class);
            //Room Type Manager
            Route::prefix('room-type')->name('room-type.')->group(function () {
                Route::get('create', [RoomTypeController::class, 'create'])->name('create');
                Route::post('create', [RoomTypeController::class, 'store']);
                Route::get('{typeRoom}/edit', [RoomTypeController::class, 'edit'])->name('edit');
                Route::post('{typeRoom}/edit', [RoomTypeController::class, 'update'])->name('update');
            });
        });

    });
});
