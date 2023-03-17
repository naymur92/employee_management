<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class CreateEmployeeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $employees = [
      [
        'name' => 'Naymur Rahman',
        'email' => 'naymur@example.com',
        'status' => 1,
        'type' => 1,
        'password' => bcrypt('abcd1234'),
      ],
      [
        'name' => 'Kamrul Hasan',
        'email' => 'kamrul@example.com',
        'status' => 0,
        'type' => 0,
        'password' => bcrypt('abcd1234'),
      ],
    ];

    foreach ($employees as $key => $employee) {
      Employee::create($employee);
    }
  }
}
