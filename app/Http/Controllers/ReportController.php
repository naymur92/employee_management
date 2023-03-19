<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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

  // Admin report query
  public function admin_reports_query()
  {
    $employees = Employee::where('status', 1)->orderBy('name', 'asc')->get();
    $positions = EmployeeDetail::groupBy('job_title')->pluck('job_title', 'job_title');

    return view('admin.pages.reports.query', compact('employees', 'positions'));
  }

  // admin report generation
  public function admin_reports_generate(Request $request)
  {
    // if position and employee are not selected
    if ($request->position == '' && $request->employee == '') {
      $attendances = EmployeeAttendance::where('entry_time', '!=', '')->where('exit_time', '!=', '')->whereBetween('date', [$request->start_date, $request->end_date])->orderBy('date', 'asc')->get();
    }
    // if only position selected
    if ($request->position != '' && $request->employee == '') {
      $position_ids = EmployeeDetail::where('job_title', $request->position)->pluck('employee_id');

      $attendances = EmployeeAttendance::whereIn('employee_id', $position_ids)->where('entry_time', '!=', '')->where('exit_time', '!=', '')->whereBetween('date', [$request->start_date, $request->end_date])->orderBy('date', 'asc')->get();
    }
    // if only employee selected
    if ($request->position == '' && $request->employee != '') {
      $attendances = EmployeeAttendance::where('employee_id', $request->employee)->where('entry_time', '!=', '')->where('exit_time', '!=', '')->whereBetween('date', [$request->start_date, $request->end_date])->orderBy('date', 'asc')->get();
    }
  }

  // employee report query
  public function employee_reports_query()
  {
    return view('pages.reports.query');
  }

  // employee report result
  public function employee_reports_generate(Request $request)
  {
    $attendances = EmployeeAttendance::where('employee_id', Auth::user()->id)->where('entry_time', '!=', '')->where('exit_time', '!=', '')->whereBetween('date', [$request->start_date, $request->end_date])->orderBy('date', 'asc')->get();

    $data = array();

    $in_time = '09:00:59';
    $late = 0;
    $total_time_in_secs = 0;

    // calculate late and total office time
    foreach ($attendances as $item) {
      if ((strtotime($in_time) - strtotime($item->entry_time)) < 0) {
        $late++;
      }
      $total_time_in_secs += (strtotime($item->exit_time) - strtotime($item->entry_time));
    }
    $average_office_time_in_sec = floor($total_time_in_secs / count($attendances));
    $average_office_time_in_min = floor($average_office_time_in_sec / 60);

    $avg_time_hr = floor($average_office_time_in_min / 60);
    $avg_time_min = $average_office_time_in_min % 60;

    $avg_time = $avg_time_hr . ' Hour : ' . $avg_time_min . ' Min';

    // generate output data
    $data['Total Late'] = $late . ($late > 1 ? ' Days' : ' Day');
    $data['Average Office Time'] = $avg_time;
    $data['Day Attends'] = count($attendances) . ' Days';

    return view('pages.reports.index', compact('data', 'attendances'));
  }
}
