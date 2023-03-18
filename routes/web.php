<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GoogleController;
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

// Employee part
Route::middleware(['auth', 'employee-access:employee'])->group(function () {
  Route::get('/', [HomeController::class, 'index'])->name('home');

  // attendances for employee
  Route::get('attendances/history', [EmployeeAttendanceController::class, 'employee_attendances'])->name('attendances.history');
});

// Admin part
Route::middleware(['auth', 'employee-access:admin'])->prefix('admin')->group(function () {
  Route::get('', [AdminController::class, 'index'])->name('admin.home');

  Route::resource('employees', EmployeeController::class);

  // delete contact
  Route::delete('employees/delete-contact/{id}', [EmployeeController::class, 'delete_contact'])->name('employees.delete_contact');

  // change employee status
  Route::put('employees/change-emp-status/{id}', [EmployeeController::class, 'change_employee_status'])->name('employees.change_emp_status');

  // attendances for admin
  Route::get('attendances/list', [EmployeeAttendanceController::class, 'index'])->name('attendances.index');
});

// common routes
Route::middleware(['auth'])->group(function () {
  Route::post('start-attendance', [EmployeeAttendanceController::class, 'start_attendance'])->name('start-attendance');
  Route::post('end-attendance', [EmployeeAttendanceController::class, 'end_attendance'])->name('end-attendance');

  Route::get('show-profile', [CommonController::class, 'show_profile'])->name('profile.show');
  Route::get('edit-profile', [CommonController::class, 'edit_profile'])->name('profile.edit');
  Route::get('view-contacts', [CommonController::class, 'view_contacts'])->name('profile.contacts');
});

Route::get('/verify-account', function () {
  return view('errors.check-activation');
});

Route::controller(GoogleController::class)->group(function () {
  Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
  Route::get('auth/google/callback', 'handleGoogleCallback');
});
