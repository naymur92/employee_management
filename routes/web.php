<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
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
  Route::get('attendances/history', [EmployeeAttendanceController::class, 'emp_attendances'])->name('attendances.history');

  Route::get('/employee-reports', [ReportController::class, 'employee_reports_query'])->name('emp_reports.query');
  Route::post('/employee-reports', [ReportController::class, 'employee_reports_generate'])->name('emp_reports.generate');
});

// Admin part
Route::middleware(['auth', 'employee-access:admin'])->prefix('admin')->group(function () {
  Route::get('', [AdminController::class, 'index'])->name('admin.home');

  Route::resource('employees', EmployeeController::class);

  // delete contact from admin employee edit page
  Route::delete('employees/delete-contact/{id}', [EmployeeController::class, 'delete_contact'])->name('employees.delete_contact');

  // change employee status
  Route::put('employees/change-emp-status/{id}', [EmployeeController::class, 'change_employee_status'])->name('employees.change_emp_status');

  // attendances for admin
  Route::get('attendances', [EmployeeAttendanceController::class, 'index'])->name('attendances.index');
  Route::get('emp-attendances/{id}', [EmployeeAttendanceController::class, 'employee_attendances'])->name('emp.attendances');

  // report generation for admin panel
  Route::get('/admin-reports', [ReportController::class, 'admin_reports_query'])->name('admin_reports.query');
  Route::post('/admin-reports', [ReportController::class, 'admin_reports_generate'])->name('admin_reports.generate');
});

// common routes
Route::middleware(['auth'])->group(function () {

  // attendance start and end
  Route::post('start-attendance', [EmployeeAttendanceController::class, 'start_attendance'])->name('start-attendance');
  Route::post('end-attendance', [EmployeeAttendanceController::class, 'end_attendance'])->name('end-attendance');

  // profile section
  Route::get('show-profile', [CommonController::class, 'show_profile'])->name('profile.show');
  Route::get('edit-profile', [CommonController::class, 'edit_profile'])->name('profile.edit');
  Route::post('update-profile/{id}', [CommonController::class, 'update_profile'])->name('profile.update');
  Route::get('view-contacts', [CommonController::class, 'view_contacts'])->name('profile.contacts');
  Route::delete('edit-profile/delete-contact/{id}', [CommonController::class, 'delete_contact'])->name('profile.delete_contact');
});

// account not activate route
Route::get('/verify-account', function () {
  return view('errors.check-activation');
});

// login with google routes
Route::controller(GoogleController::class)->group(function () {
  Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
  Route::get('auth/google/callback', 'handleGoogleCallback');
});
