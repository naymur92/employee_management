<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeContact;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $employees = Employee::get();
    return view('admin.pages.employees.index', compact('employees'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.pages.employees.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|min:4',
      'email' => 'required|email|unique:employees,email',
      'status' => 'required',
      'type' => 'required',
      'jobtitle' => 'required',
      'gender' => 'required',
      'dob' => 'required',
      'photo' => 'required|mimes:jpg,jpeg,png|max:2000',
      // 'contact_name.*' => 'required',
      // 'contact_phone.*' => 'numeric',
      // 'contact_relation.*' => 'required',
    ]);

    $employee = Employee::create([
      'name' => $request->name,
      'email' => $request->email,
      'status' => $request->status,
      'type' => $request->type,
      'password' => Hash::make($request->password),
    ]);

    flash()->addSuccess('Employee Added');

    $image_name = '';

    if ($image = $request->file('photo')) {
      $fileName = '(' . $employee->id . ').' . $image->extension();
      $image->move(public_path('assets/images/employees_photos'), $fileName);
      $image_name = $fileName;
    } else {
      $image_name = 'no_image.jpg';
    }

    EmployeeDetail::create([
      'employee_id' => $employee->id,
      'job_title' => $request->jobtitle,
      'address' => $request->address,
      'gender' => $request->gender,
      'dob' => $request->dob,
      'photo' => $image_name,
    ]);

    flash()->addSuccess('Employee Detail Added');

    $contact_length = count($request->contact_name);

    for ($i = 0; $i < $contact_length; $i++) {
      if ($request->contact_name[$i] == '' || $request->contact_phone[$i] == '' || $request->contact_relation[$i] == '') continue;
      EmployeeContact::create([
        'employee_id' => $employee->id,
        'contact_name' => $request->contact_name[$i],
        'contact_email' => $request->contact_email[$i],
        'contact_phone' => $request->contact_phone[$i],
        'contact_relation' => $request->contact_relation[$i],
      ]);
    }

    flash()->addSuccess('Employee Contacts Added');

    return redirect(route('employees.index'));
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Employee  $employee
   * @return \Illuminate\Http\Response
   */
  public function show(Employee $employee)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Employee  $employee
   * @return \Illuminate\Http\Response
   */
  public function edit(Employee $employee)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Employee  $employee
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Employee $employee)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Employee  $employee
   * @return \Illuminate\Http\Response
   */
  public function destroy(Employee $employee)
  {
    //
  }
}
