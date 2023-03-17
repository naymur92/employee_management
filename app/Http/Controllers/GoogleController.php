<?php



namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller

{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function redirectToGoogle()
  {
    return Socialite::driver('google')->redirect();
  }

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function handleGoogleCallback()
  {
    try {
      $googleUser = Socialite::driver('google')->stateless()->user(); // in production remove ->stateless()
      $findemployee = Employee::where('google_id', $googleUser->id)->first();
      if ($findemployee) {
        Auth::login($findemployee);

        // check employee status
        if (auth()->user()->status == 'pending') {
          return redirect()->intended('/verify-account');
        }

        // check employee type
        if (auth()->user()->type == 'admin') {
          return redirect()->intended('/admin');
        } else {
          return redirect()->intended('/');
        }
      } else {
        $newEmployee = Employee::updateOrCreate(['email' => $googleUser->email], [
          'name' => $googleUser->name,
          'google_id' => $googleUser->id,
          'password' => bcrypt('abcd1234')
        ]);

        Auth::login($newEmployee);

        return redirect()->intended('/verify-account');
      }
    } catch (Exception $e) {

      dd($e->getMessage());
    }
  }
}
