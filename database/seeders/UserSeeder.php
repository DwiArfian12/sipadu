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
        User::create([
            'name' => 'Superadmin AFDAPER',
            'email' => 'superadmin@afdaper.uny.ac.id',
            'nip' => '198001012010011001',
            'phone' => '081234567890',
            'role' => 'superadmin',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 1 - Berita
        User::create([
            'name' => 'Admin Berita',
            'email' => 'admin.berita@afdaper.uny.ac.id',
            'nip' => '198501012015012001',
            'phone' => '081298765431',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 2 - Mahasiswa
        User::create([
            'name' => 'Admin Mahasiswa',
            'email' => 'admin.mahasiswa@afdaper.uny.ac.id',
            'nip' => '199001012018012002',
            'phone' => '081212345678',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 3 - Dosen
        User::create([
            'name' => 'Admin Dosen',
            'email' => 'admin.dosen@afdaper.uny.ac.id',
            'nip' => '199201012020012003',
            'phone' => '085611122233',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 4 - Penelitian
        User::create([
            'name' => 'Admin Penelitian',
            'email' => 'admin.penelitian@afdaper.uny.ac.id',
            'nip' => '198702012015012004',
            'phone' => '081312345671',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 5 - Pengabdian kepada Masyarakat
        User::create([
            'name' => 'Admin Pengabdian',
            'email' => 'admin.pengabdian@afdaper.uny.ac.id',
            'nip' => '198803012016012005',
            'phone' => '081412345672',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 6 - Tenaga Kependidikan
        User::create([
            'name' => 'Admin Tenaga Kependidikan',
            'email' => 'admin.tendik@afdaper.uny.ac.id',
            'nip' => '198904012017012006',
            'phone' => '081512345673',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 7 - Fasilitas
        User::create([
            'name' => 'Admin Fasilitas',
            'email' => 'admin.fasilitas@afdaper.uny.ac.id',
            'nip' => '199005012018012007',
            'phone' => '081612345674',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 8 - Organisasi Kemahasiswaan
        User::create([
            'name' => 'Admin Ormawa',
            'email' => 'admin.ormawa@afdaper.uny.ac.id',
            'nip' => '199106012019012008',
            'phone' => '081712345675',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 9 - Jaringan Alumni
        User::create([
            'name' => 'Admin Alumni',
            'email' => 'admin.alumni@afdaper.uny.ac.id',
            'nip' => '199207012020012009',
            'phone' => '081812345676',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        // Admin Data 10 - Keuangan
        User::create([
            'name' => 'Admin Keuangan',
            'email' => 'admin.keuangan@afdaper.uny.ac.id',
            'nip' => '199308012020012010',
            'phone' => '081912345677',
            'role' => 'admin_data',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
