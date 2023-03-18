<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $emp_id = auth()->user()->id;
    $date = date('Y-m-d');

    $if_att_exists = EmployeeAttendance::where('employee_id', $emp_id)->where('date', $date)->first();
    return view('home', compact('if_att_exists'));
  }

  // report query
  public function employee_reports_query()
  {
    return view('pages.reports.query');
  }

  // report result
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
