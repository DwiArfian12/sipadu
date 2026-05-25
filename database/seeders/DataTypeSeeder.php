<?php

namespace Database\Seeders;

use App\Models\DataType;
use App\Models\DataField;
use App\Models\User;
use Illuminate\Database\Seeder;

class DataTypeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Berita UNY
        $berita = DataType::create([
            'name' => 'Berita UNY',
            'description' => 'Kumpulan berita terbaru dari Universitas Negeri Yogyakarta',
        ]);

        DataField::create([
            'data_type_id' => $berita->id,
            'name' => 'judul',
            'label' => 'Judul Berita',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $berita->id,
            'name' => 'excerpt',
            'label' => 'Ringkasan',
            'type' => 'textarea',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 2,
        ]);

        DataField::create([
            'data_type_id' => $berita->id,
            'name' => 'author',
            'label' => 'Penulis',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 3,
        ]);

        DataField::create([
            'data_type_id' => $berita->id,
            'name' => 'image',
            'label' => 'Gambar Berita',
            'type' => 'image',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $berita->id,
            'name' => 'content',
            'label' => 'Isi Berita',
            'type' => 'textarea',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $berita->id,
            'name' => 'kategori',
            'label' => 'Kategori',
            'type' => 'dropdown',
            'options' => json_encode(['Akademik', 'Kemahasiswaan', 'Penelitian', 'Pengabdian', 'Olahraga', 'Seni']),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 6,
        ]);

        DataField::create([
            'data_type_id' => $berita->id,
            'name' => 'tanggal_publikasi',
            'label' => 'Tanggal Publikasi',
            'type' => 'date',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 7,
        ]);

        // 2. Mahasiswa
        $mahasiswa = DataType::create([
            'name' => 'Mahasiswa',
            'description' => 'Data mahasiswa aktif Universitas Negeri Yogyakarta',
        ]);

        DataField::create([
            'data_type_id' => $mahasiswa->id,
            'name' => 'nama',
            'label' => 'Nama Mahasiswa',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $mahasiswa->id,
            'name' => 'nim',
            'label' => 'NIM',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 2,
        ]);

        DataField::create([
            'data_type_id' => $mahasiswa->id,
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 3,
        ]);

        DataField::create([
            'data_type_id' => $mahasiswa->id,
            'name' => 'prodi',
            'label' => 'Program Studi',
            'type' => 'dropdown',
            'options' => json_encode([
                'Pendidikan Teknik Informatika',
                'Pendidikan Teknik Elektro',
                'Pendidikan Teknik Mesin',
                'Pendidikan Teknik Sipil',
                'Teknik Elektro',
                'Teknik Informatika',
                'Manajemen',
                'Akuntansi',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $mahasiswa->id,
            'name' => 'angkatan',
            'label' => 'Angkatan',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $mahasiswa->id,
            'name' => 'foto',
            'label' => 'Foto Mahasiswa',
            'type' => 'image',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 6,
        ]);

        // 3. Dosen
        $dosen = DataType::create([
            'name' => 'Dosen',
            'description' => 'Data dosen Universitas Negeri Yogyakarta',
        ]);

        DataField::create([
            'data_type_id' => $dosen->id,
            'name' => 'nama',
            'label' => 'Nama Dosen',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $dosen->id,
            'name' => 'nip',
            'label' => 'NIP',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 2,
        ]);

        DataField::create([
            'data_type_id' => $dosen->id,
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 3,
        ]);

        DataField::create([
            'data_type_id' => $dosen->id,
            'name' => 'bidang_keahlian',
            'label' => 'Bidang Keahlian',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $dosen->id,
            'name' => 'jabatan_fungsional',
            'label' => 'Jabatan Fungsional',
            'type' => 'dropdown',
            'options' => json_encode([
                'Tenaga Pengajar',
                'Asisten Ahli',
                'Lektor',
                'Lektor Kepala',
                'Guru Besar',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $dosen->id,
            'name' => 'alamat',
            'label' => 'Alamat',
            'type' => 'textarea',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 6,
        ]);

        // Assign admin to data types
        $adminBerita = User::where('email', 'admin.berita@afdaper.uny.ac.id')->first();
        $adminMahasiswa = User::where('email', 'admin.mahasiswa@afdaper.uny.ac.id')->first();
        $adminDosen = User::where('email', 'admin.dosen@afdaper.uny.ac.id')->first();

        if ($adminBerita) {
            $adminBerita->dataTypes()->attach($berita->id);
        }
        if ($adminMahasiswa) {
            $adminMahasiswa->dataTypes()->attach($mahasiswa->id);
        }
        if ($adminDosen) {
            $adminDosen->dataTypes()->attach($dosen->id);
        }
    }
}