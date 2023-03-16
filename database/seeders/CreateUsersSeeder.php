<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $users = [
      [
        'name' => 'Naymur Rahman',
        'email' => 'naymur@example.com',
        'type' => 1,
        'password' => bcrypt('123456'),
      ],
      [
        'name' => 'Kamrul Hasan',
        'email' => 'kamrul@example.com',
        'type' => 0,
        'password' => bcrypt('123456'),
      ],
    ];

    foreach ($users as $key => $user) {
      User::create($user);
    }
  }
}
