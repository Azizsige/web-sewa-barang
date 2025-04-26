<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    User::firstOrCreate(
      ['email' => 'admin@tokosewa.com'],
      [
        'name' => 'Admin Toko',
        'password' => bcrypt('password'),
        'role' => 'admin',
      ]
    );

    User::firstOrCreate(
      ['email' => 'dev@tokosewa.com'],
      [
        'name' => 'Developer',
        'password' => bcrypt('password'),
        'role' => 'developer',
      ]
    );
  }
}
