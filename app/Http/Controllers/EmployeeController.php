<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeContact;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $employees = Employee::orderBy('created_at', 'desc')->get();
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
      'photo' => 'mimes:jpg,jpeg,png|max:2000',
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
    return view('admin.pages.employees.show', compact('employee'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Employee  $employee
   * @return \Illuminate\Http\Response
   */
  public function edit(Employee $employee)
  {
    if ($employee->type == 'admin' || $employee->id == Auth::user()->id) {
      flash()->addError('Unauthorized Access');
      return redirect(route('employees.index'));
    }
    return view('admin.pages.employees.edit', compact('employee'));
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
    $request->validate([
      'name' => 'required|min:4',
      'email' => 'required|email|unique:employees,email,' . $employee->id,
      'status' => 'required',
      'type' => 'required',
      'jobtitle' => 'required',
      'gender' => 'required',
      'dob' => 'required',
      'photo' => 'mimes:jpg,jpeg,png|max:2000',
    ]);

    $data['name'] = $request->name;
    $data['email'] = $request->email;
    $data['status'] = $request->status;
    $data['type'] = $request->type;

    if ($employee->update($data)) {
      flash()->addSuccess('Employee Updated');
    }

    // update employee detail
    if ($employee->detail) {
      $old_img = $employee->detail->photo;
    }

    if ($image = $request->file('photo')) {
      // Delete old file
      if ($employee->detail && $old_img != 'no_image.jpg') {
        unlink(public_path('assets/images/employees_photos/' . $old_img));
      }

      $fileName = '(' . $employee->id . ').' . $image->extension();
      $image->move(public_path('assets/images/employees_photos'), $fileName);
      $emp_detail['photo'] = $fileName;
    }

    $emp_detail['job_title'] = $request->jobtitle;
    $emp_detail['address'] = $request->address;
    $emp_detail['gender'] = $request->gender;
    $emp_detail['dob'] = $request->dob;

    if ($employee->detail) {
      if ($employee->detail->update($emp_detail)) {
        flash()->addSuccess('Employee Detail Updated');
      }
    } else {
      $emp_detail['employee_id'] = $employee->id;
      $emp_detail['photo'] = 'no_image.jpg';
      if (EmployeeDetail::create($emp_detail)) {
        flash()->addSuccess('Employee Detail Added');
      }
    }

    $contact_length = count($request->contact_name);

    for ($i = 0; $i < $contact_length; $i++) {
      if ($request->contact_name[$i] == '' || $request->contact_phone[$i] == '' || $request->contact_relation[$i] == '') continue;

      if (isset($request->contact_id[$i])) {
        $emp_contact = EmployeeContact::findOrFail($request->contact_id[$i]);
        $emp_contact->update([
          'contact_name' => $request->contact_name[$i],
          'contact_email' => $request->contact_email[$i],
          'contact_phone' => $request->contact_phone[$i],
          'contact_relation' => $request->contact_relation[$i],
        ]);
        flash()->addSuccess('Employee Contact Updated');
        continue;
      }

      EmployeeContact::create([
        'employee_id' => $employee->id,
        'contact_name' => $request->contact_name[$i],
        'contact_email' => $request->contact_email[$i],
        'contact_phone' => $request->contact_phone[$i],
        'contact_relation' => $request->contact_relation[$i],
      ]);
      flash()->addSuccess('Employee Contacts Added');
    }
    return redirect(route('employees.index'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Employee  $employee
   * @return \Illuminate\Http\Response
   */
  public function destroy(Employee $employee)
  {
    if (isset($employee->detail) && $employee->detail->photo != 'no_image.jpg') {
      unlink(public_path('assets/images/employees_photos/' . $employee->detail->photo));
    }

    $employee->delete();
    flash()->addSuccess('Employee Deleted');

    return redirect(route('employees.index'));
  }

  // delete contact according to employees
  public function delete_contact($id)
  {
    $contact = EmployeeContact::findOrFail($id);
    $contact->delete();
    flash()->addSuccess('Contact Deleted');

    return response()->json(['success' => true]);
  }

  // confirm employee
  public function change_employee_status(Request $request, $id)
  {
    $employee = Employee::findOrFail($id);

    $status = $request->status;

    $employee->status = $status;
    $employee->save();

    flash()->addSuccess('Status Updated');

    return back();
    // return redirect(route('employees.index'));
  }
}
