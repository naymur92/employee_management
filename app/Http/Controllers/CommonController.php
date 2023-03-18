<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeContact;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    return view('common_pages.edit-profile', compact('employee'));
  }


  public function update_profile(Request $request, $id)
  {
    $employee = Employee::findOrFail($id);

    $request->validate([
      'name' => 'required|min:4',
      'email' => 'required|email|unique:employees,email,' . $id,
      'password' => 'confirmed',
      'gender' => 'required',
      'dob' => 'required',
      'photo' => 'mimes:jpg,jpeg,png|max:2000',
    ]);

    $data['name'] = $request->name;
    $data['email'] = $request->email;

    if ($request->password != '') {
      $data['password'] = Hash::make($request->password);
    }

    if ($employee->update($data)) {
      flash()->addSuccess('Profile Updated');
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

      $fileName = '(' . $id . ').' . $image->extension();
      $image->move(public_path('assets/images/employees_photos'), $fileName);
      $emp_detail['photo'] = $fileName;
    }

    $emp_detail['address'] = $request->address;
    $emp_detail['gender'] = $request->gender;
    $emp_detail['dob'] = $request->dob;

    if ($employee->detail) {
      if ($employee->detail->update($emp_detail)) {
        flash()->addSuccess('Profile Detail Updated');
      }
    } else {
      $emp_detail['employee_id'] = $id;
      $emp_detail['photo'] = 'no_image.jpg';
      if (EmployeeDetail::create($emp_detail)) {
        flash()->addSuccess('Profile Detail Added');
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
        flash()->addSuccess('Profile Contact Updated');
        continue;
      }

      EmployeeContact::create([
        'employee_id' => $employee->id,
        'contact_name' => $request->contact_name[$i],
        'contact_email' => $request->contact_email[$i],
        'contact_phone' => $request->contact_phone[$i],
        'contact_relation' => $request->contact_relation[$i],
      ]);
      flash()->addSuccess('Profile Contacts Added');
    }
    return back();
  }

  public function view_contacts()
  {
    $contacts = Employee::findOrFail(auth()->user()->id)->contacts;

    return view('common_pages.contacts', compact('contacts'));
  }

  public function delete_contact($id)
  {
    $contact = EmployeeContact::findOrFail($id);
    $contact->delete();
    flash()->addSuccess('Contact Deleted');

    return response()->json(['success' => true]);
  }
}
