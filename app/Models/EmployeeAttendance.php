<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'date', 'entry_time', 'exit_time'];

    public function employee()
    {
        return $this->belongsTo(related: Employee::class, foreignKey: 'employee_id');
    }
}
