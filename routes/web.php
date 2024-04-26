<?php

use App\Http\Controllers\User\AuthController;
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

//Authentication
Route::get('/sign-up', [UserPageController::class, 'signup'])->name('signup');
Route::get('/log-in', [UserPageController::class, 'login'])->name('login');

Route::post('/sign-up', [AuthController::class, 'register'])->name('register');
Route::post('/log-in', [AuthController::class, 'signin'])->name('signin');

Route::get('/send-verify-code/{code}', [AuthController::class, 'sendVerifyCode'])->name('send_verify_code');

//User Account
Route::get('/verify-code', [UserPageController::class, 'verifyCode'])->name('verify_code');
Route::post('/verify-code', [AuthController::class, 'verify']);
Route::get('/re-active-account', [UserPageController::class, 'reActiveAccount'])->name('re_active_account');
