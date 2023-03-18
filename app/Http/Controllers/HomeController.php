<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;

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
}
