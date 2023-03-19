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
    $start_date = $request->start_date;
    $end_date = $request->end_date;

    // if both are selected
    if ($request->position != '' && $request->employee != '') {
      flash()->addWarning('Please Select one from Employee and Position');
      return back();
    }

    // if only employee selected
    if ($request->position == '' && $request->employee != '') {
      $employee = Employee::findOrFail($request->employee);
      $attendances = EmployeeAttendance::where('employee_id', $request->employee)->where('entry_time', '!=', '')->where('exit_time', '!=', '')->whereBetween('date', [$request->start_date, $request->end_date])->orderBy('date', 'asc')->get();

      // generate data
      $data = $this->generate_single_data($attendances);
      return view('admin.pages.reports.single', compact('attendances', 'employee', 'data'));
    }


    // if position and employee are not selected
    if ($request->position == '' && $request->employee == '') {
      $employee_ids = Employee::pluck('id');

      $reports = $this->generate_attendance_report_by_emp_ids_and_dates($employee_ids, $start_date, $end_date);

      // echo '<pre>';
      // print_r($reports);
      // return;
      return view('admin.pages.reports.index', compact('reports'));
    }
    // if only position selected
    if ($request->position != '' && $request->employee == '') {
      $employee_ids = EmployeeDetail::where('job_title', $request->position)->pluck('employee_id');

      $reports = $this->generate_attendance_report_by_emp_ids_and_dates($employee_ids, $start_date, $end_date);

      return view('admin.pages.reports.index', compact('reports'));
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

    $data = $this->generate_single_data($attendances);

    return view('pages.reports.index', compact('data', 'attendances'));
  }

  // method for generate single employee attendance data
  public function generate_single_data($attendances)
  {
    $data = array();

    if (count($attendances) == 0) return $data;

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

    return $data;
  }

  // generate report by employee ids
  public function generate_attendance_report_by_emp_ids_and_dates($employee_ids, $start_date, $end_date)
  {
    $report = array();
    foreach ($employee_ids as $id) {
      $employee = Employee::findOrFail($id);
      $attendances = EmployeeAttendance::where('employee_id', $id)->where('entry_time', '!=', '')->where('exit_time', '!=', '')->whereBetween('date', [$start_date, $end_date])->orderBy('date', 'asc')->get();

      $report[$id] = [
        'id' => $id,
        'name' => $employee->name,
        'email' => $employee->email,
        'job_title' => $employee->detail->job_title ?? 'N/A',
      ];
      if (count($attendances) == 0) {
        $report[$id]['data'] = [
          'day_attends' => 'No Data Available',
          'total_late' => 'No Data Available',
          'avg_office_time' => 'No Data Available',
        ];
      } else {
        $data = $this->generate_single_data($attendances);

        $report[$id]['data'] = [
          'day_attends' => $data["Day Attends"],
          'total_late' => $data["Total Late"],
          'avg_office_time' => $data["Average Office Time"],
        ];
      }
    }
    $report = json_decode(json_encode($report), FALSE);
    return $report;
  }
}
