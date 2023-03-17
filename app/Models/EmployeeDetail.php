<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'job_title', 'address', 'gender', 'dob', 'photo'];

    public function employee()
    {
        return $this->belongsTo(related: Employee::class, foreignKey: 'employee_id');
    }
}
