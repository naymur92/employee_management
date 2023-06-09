<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Employee extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'status',
    'type',
    'google_id'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  protected function status(): Attribute
  {
    return new Attribute(
      get: fn ($value) =>  ["pending", "confirmed"][$value],
    );
  }

  protected function type(): Attribute
  {
    return new Attribute(
      get: fn ($value) =>  ["employee", "admin"][$value],
    );
  }

  public function detail()
  {
    return $this->hasOne(related: EmployeeDetail::class, foreignKey: 'employee_id');
  }

  public function contacts()
  {
    return $this->hasMany(related: EmployeeContact::class, foreignKey: 'employee_id');
  }

  public function attendances()
  {
    return $this->hasMany(related: EmployeeAttendance::class, foreignKey: 'employee_id');
  }
}
