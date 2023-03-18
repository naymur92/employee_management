<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $emp_id = auth()->user()->id;
    $date = date('Y-m-d');

    $if_att_exists = EmployeeAttendance::where('employee_id', $emp_id)->where('date', $date)->first();

    // var_dump($if_att_exists);
    return view('admin', compact('if_att_exists'));
  }
}
