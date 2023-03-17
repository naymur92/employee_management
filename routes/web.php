<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware(['auth', 'employee-access:employee'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});


Route::middleware(['auth', 'employee-access:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');
});
