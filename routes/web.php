<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\User\UserPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StaffController;

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
    Route::get('/personal-information', [CustomerController::class,'getUserInfo'])->name('get-user-info');
    Route::post('/personal-information', [CustomerController::class,'updateUserInfo'])->name('update-user-info');
});

Route::prefix('admin')->name('admin.')->group(function ()
{
    //Admin authentication
    Route::get('/login', [AdminController::class,'login'])->name('login');
    Route::post('/login', [AdminController::class,'signin']);
    Route::get('/logout', [AdminController::class,'logout'])->name('logout');

   Route::middleware('staffs')->group(function () {
       Route::get('/', [AdminController::class,'index'])->name('dashboard');

       //Customer manager
       Route::resource('customers', AdminCustomerController::class);
       //User manager
       Route::resource('users', AdminUserController::class);
       //Device Manager
       Route::resource('devices', DeviceController::class);
       //GET room type
       Route::get('room-type', [RoomTypeController::class, 'index'])->name('room-type.index');

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
               Route::get('images/{code}', [RoomTypeController::class, 'getImages'])->name('images');
               Route::post('images/change-thumb/{typeRoom}', [RoomTypeController::class, 'changeThumbNail'])->name('images.thumb');
               Route::delete('images/{roomImage}', [RoomTypeController::class, 'deleteImage'])->name('images.delete');
               Route::post('images/change-detail/{typeRoom}', [RoomTypeController::class, 'changeDetail'])->name('images.detail');
           });
       });
   });
});
