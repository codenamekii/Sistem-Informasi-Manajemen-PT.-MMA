<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
  public function run(): void
  {
    $users = [
      [
        'name' => 'Super Admin',
        'email' => 'superadmin@mma.test',
        'role' => User::ROLE_SUPER_ADMIN,
      ],
      [
        'name' => 'Admin Operasional',
        'email' => 'admin@mma.test',
        'role' => User::ROLE_ADMIN_OPERASIONAL,
      ],
      [
        'name' => 'Koordinator Operasional',
        'email' => 'koordinator@mma.test',
        'role' => User::ROLE_KOORDINATOR_OPERASIONAL,
      ],
      [
        'name' => 'Petugas Lapangan',
        'email' => 'petugas@mma.test',
        'role' => User::ROLE_PETUGAS_LAPANGAN,
      ],
      [
        'name' => 'Manajer Operasional',
        'email' => 'manajer@mma.test',
        'role' => User::ROLE_MANAJER_OPERASIONAL,
      ],
      [
        'name' => 'Direktur',
        'email' => 'direktur@mma.test',
        'role' => User::ROLE_DIREKTUR,
      ],
    ];

    foreach ($users as $data) {
      User::updateOrCreate(
        ['email' => $data['email']],
        [
          'name' => $data['name'],
          'role' => $data['role'],
          'password' => Hash::make('password123'),
        ]
      );
    }
  }
}