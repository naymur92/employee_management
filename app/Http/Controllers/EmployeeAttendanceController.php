<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EmployeeAccess;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeAttendanceController extends Controller
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

  // get attendances for admin panel
  public function index()
  {
    $attendances = EmployeeAttendance::orderBy('updated_at', 'desc')->get();
    return view('admin.pages.attendances.index', compact('attendances'));
  }

  // attendances list for employee
  public function employee_attendances()
  {
    $attendances = EmployeeAttendance::where('employee_id', Auth::user()->id)->orderBy('updated_at', 'desc')->get();
    return view('pages.attendances.index', compact('attendances'));
  }

  // Start attendance
  public function start_attendance()
  {
    $emp_id = auth()->user()->id;
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $if_att_exists = EmployeeAttendance::where('employee_id', $emp_id)->where('date', $date)->first();

    if (isset($if_att_exists) && $if_att_exists->entry_time != '') {
      flash()->addError('Already give attendence');
      return back();
    }

    if (!isset($if_att_exists)) {
      EmployeeAttendance::create([
        'employee_id' => $emp_id,
        'date' => $date,
        'entry_time' => $time
      ]);
      flash()->addSuccess('Attendance start success');
      return back();
    } else if ($if_att_exists->entry_time == '') {
      $if_att_exists->update([
        'entry_time' => $time
      ]);

      flash()->addSuccess('Attendance updated');
      return back();
    }
  }

  // end attendance
  public function end_attendance()
  {
    $emp_id = auth()->user()->id;
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $if_att_exists = EmployeeAttendance::where('employee_id', $emp_id)->where('date', $date)->first();

    if (!isset($if_att_exists) || $if_att_exists->entry_time == '') {
      flash()->addWarning('Please give attendance first!');
      return back();
    }

    if ($if_att_exists->exit_time != '') {
      flash()->addError('Already end attendence');
      return back();
    }

    if ($if_att_exists->entry_time != '') {
      $if_att_exists->update([
        'exit_time' => $time
      ]);

      flash()->addSuccess('Attendance end success');
      return back();
    }
  }
}
