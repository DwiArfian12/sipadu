<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        $superadmin = User::create([
            'name' => 'Superadmin AFDAPER',
            'email' => 'superadmin@afdaper.uny.ac.id',
            'nip' => '198001012010011001',
            'phone' => '081234567890',
            'role' => 'superadmin',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 1 - Berita
        $admin1 = User::create([
            'name' => 'Admin Berita',
            'email' => 'admin.berita@afdaper.uny.ac.id',
            'nip' => '198501012015012001',
            'phone' => '081298765431',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 2 - Mahasiswa
        $admin2 = User::create([
            'name' => 'Admin Mahasiswa',
            'email' => 'admin.mahasiswa@afdaper.uny.ac.id',
            'nip' => '199001012018012002',
            'phone' => '081212345678',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 3 - Dosen
        $admin3 = User::create([
            'name' => 'Admin Dosen',
            'email' => 'admin.dosen@afdaper.uny.ac.id',
            'nip' => '199201012020012003',
            'phone' => '085611122233',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}