<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserPageController;
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
Route::get('/log-in', [UserPageController::class, 'login'])->name('login');
Route::get('/sign-up', [UserPageController::class, 'signup'])->name('signup');

Route::post('/sign-up', [AuthController::class, 'register'])->name('register');
