<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Alumni;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun admin
        $adminUser = User::create([
            'role' => 0,
            'name' => 'Admin User',
            'nomor_induk' => 'ADM001',
            'password' => Hash::make('password123'),
            'email' => 'admin123@gmail.com'
        ]);

        Admin::create([
            'id_user' => $adminUser->id,
            'nama' => 'Admin User',
            'nomor_induk' => 'ADM001',
            'no_hp' => '081234567890',
        ]);

        // Membuat akun alumni
        $alumniUser = User::create([
            'role' => 1,
            'name' => 'Noval Achmad Raisha',
            'nomor_induk' => '3202116067',
            'email' => 'novalachmadraisha@gmail.com',
            'password' => Hash::make('noval123'),
        ]);

        Alumni::create([
            'id_user' => $alumniUser->id,
            'nim' => '3202116067',
            'nama_alumni' => 'Noval Achmad Raisha',
            'angkatan' => '2021',
            'no_tlp' => '081234567891',
            'email' => 'novalachmadraisha@gmail.com',
        ]);
    }
}
