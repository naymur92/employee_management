<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class CommonController extends Controller
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


  public function show_profile()
  {
    $employee = Employee::findOrFail(auth()->user()->id);

    return view('common_pages.profile', compact('employee'));
  }

  public function edit_profile()
  {
    $employee = Employee::findOrFail(auth()->user()->id);

    return view('common_pages.profile', compact('employee'));
  }

  public function view_contacts()
  {
    $contacts = Employee::findOrFail(auth()->user()->id)->contacts;

    return view('common_pages.contacts', compact('contacts'));
  }
}
