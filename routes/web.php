<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\CustomerController;
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
