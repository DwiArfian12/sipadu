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
        // ===================== 1. BERITA =====================
        $berita = DataType::create([
            'name' => 'Berita',
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

        // ===================== 2. DOSEN =====================
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

        // ===================== 3. MAHASISWA =====================
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

        // ===================== 4. PENELITIAN =====================
        $penelitian = DataType::create([
            'name' => 'Penelitian',
            'description' => 'Data penelitian yang dilakukan oleh dosen Universitas Negeri Yogyakarta',
        ]);

        DataField::create([
            'data_type_id' => $penelitian->id,
            'name' => 'judul_penelitian',
            'label' => 'Judul Penelitian',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $penelitian->id,
            'name' => 'ketua_peneliti',
            'label' => 'Ketua Peneliti',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 2,
        ]);

        DataField::create([
            'data_type_id' => $penelitian->id,
            'name' => 'anggota',
            'label' => 'Anggota Peneliti',
            'type' => 'textarea',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 3,
        ]);

        DataField::create([
            'data_type_id' => $penelitian->id,
            'name' => 'sumber_dana',
            'label' => 'Sumber Dana',
            'type' => 'dropdown',
            'options' => json_encode([
                'Mandiri',
                'Hibah Internal UNY',
                'Hibah DIKTI',
                'Hibah Kemendikbudristek',
                'Hibah Internasional',
                'Kerjasama Industri',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $penelitian->id,
            'name' => 'dana',
            'label' => 'Jumlah Dana (Rp)',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $penelitian->id,
            'name' => 'tahun',
            'label' => 'Tahun Pelaksanaan',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 6,
        ]);

        DataField::create([
            'data_type_id' => $penelitian->id,
            'name' => 'file_laporan',
            'label' => 'File Laporan',
            'type' => 'file',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 7,
        ]);

        // ===================== 5. PENGABDIAN KEPADA MASYARAKAT =====================
        $pkm = DataType::create([
            'name' => 'Pengabdian kepada Masyarakat',
            'description' => 'Data kegiatan pengabdian kepada masyarakat oleh civitas akademika UNY',
        ]);

        DataField::create([
            'data_type_id' => $pkm->id,
            'name' => 'judul_kegiatan',
            'label' => 'Judul Kegiatan',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $pkm->id,
            'name' => 'ketua_pelaksana',
            'label' => 'Ketua Pelaksana',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 2,
        ]);

        DataField::create([
            'data_type_id' => $pkm->id,
            'name' => 'lokasi',
            'label' => 'Lokasi Kegiatan',
            'type' => 'text',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 3,
        ]);

        DataField::create([
            'data_type_id' => $pkm->id,
            'name' => 'mitra',
            'label' => 'Mitra Sasaran',
            'type' => 'text',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $pkm->id,
            'name' => 'sumber_dana',
            'label' => 'Sumber Dana',
            'type' => 'dropdown',
            'options' => json_encode([
                'Mandiri',
                'Hibah Internal UNY',
                'Hibah DIKTI',
                'Hibah Kemendikbudristek',
                'CSR Perusahaan',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $pkm->id,
            'name' => 'dana',
            'label' => 'Jumlah Dana (Rp)',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 6,
        ]);

        DataField::create([
            'data_type_id' => $pkm->id,
            'name' => 'tahun',
            'label' => 'Tahun Pelaksanaan',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 7,
        ]);

        DataField::create([
            'data_type_id' => $pkm->id,
            'name' => 'dokumentasi',
            'label' => 'Dokumentasi Kegiatan',
            'type' => 'image',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 8,
        ]);

        // ===================== 6. TENAGA KEPENDIDIKAN =====================
        $tendik = DataType::create([
            'name' => 'Tenaga Kependidikan',
            'description' => 'Data tenaga kependidikan (tendik) di lingkungan Universitas Negeri Yogyakarta',
        ]);

        DataField::create([
            'data_type_id' => $tendik->id,
            'name' => 'nama',
            'label' => 'Nama Tendik',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $tendik->id,
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
            'data_type_id' => $tendik->id,
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
            'data_type_id' => $tendik->id,
            'name' => 'unit_kerja',
            'label' => 'Unit Kerja',
            'type' => 'dropdown',
            'options' => json_encode([
                'Rektorat',
                'Fakultas Teknik',
                'Fakultas Ekonomi',
                'Fakultas Ilmu Pendidikan',
                'Fakultas Bahasa dan Seni',
                'Fakultas Matematika dan IPA',
                'Fakultas Ilmu Sosial',
                'Fakultas Olahraga',
                'LPPM',
                'LPPMP',
                'UPT Perpustakaan',
                'UPT TIK',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $tendik->id,
            'name' => 'jabatan',
            'label' => 'Jabatan',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $tendik->id,
            'name' => 'pendidikan_terakhir',
            'label' => 'Pendidikan Terakhir',
            'type' => 'dropdown',
            'options' => json_encode([
                'SMA/Sederajat',
                'D3',
                'D4',
                'S1',
                'S2',
                'S3',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 6,
        ]);

        DataField::create([
            'data_type_id' => $tendik->id,
            'name' => 'foto',
            'label' => 'Foto',
            'type' => 'image',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 7,
        ]);

        // ===================== 7. FASILITAS =====================
        $fasilitas = DataType::create([
            'name' => 'Fasilitas',
            'description' => 'Data inventarisasi fasilitas dan sarana prasarana Universitas Negeri Yogyakarta',
        ]);

        DataField::create([
            'data_type_id' => $fasilitas->id,
            'name' => 'nama_fasilitas',
            'label' => 'Nama Fasilitas',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $fasilitas->id,
            'name' => 'jenis',
            'label' => 'Jenis Fasilitas',
            'type' => 'dropdown',
            'options' => json_encode([
                'Gedung',
                'Ruang Kelas',
                'Laboratorium',
                'Perpustakaan',
                'Sarana Olahraga',
                'Sarana Kesenian',
                'Asrama Mahasiswa',
                'Kendaraan',
                'Alat Laboratorium',
                'Lainnya',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 2,
        ]);

        DataField::create([
            'data_type_id' => $fasilitas->id,
            'name' => 'lokasi',
            'label' => 'Lokasi',
            'type' => 'text',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 3,
        ]);

        DataField::create([
            'data_type_id' => $fasilitas->id,
            'name' => 'kondisi',
            'label' => 'Kondisi',
            'type' => 'dropdown',
            'options' => json_encode([
                'Baik',
                'Rusak Ringan',
                'Rusak Berat',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $fasilitas->id,
            'name' => 'jumlah',
            'label' => 'Jumlah',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $fasilitas->id,
            'name' => 'tahun_pengadaan',
            'label' => 'Tahun Pengadaan',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 6,
        ]);

        DataField::create([
            'data_type_id' => $fasilitas->id,
            'name' => 'foto',
            'label' => 'Foto Fasilitas',
            'type' => 'image',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 7,
        ]);

        // ===================== 8. ORGANISASI KEMAHASISWAAN =====================
        $ormawa = DataType::create([
            'name' => 'Organisasi Kemahasiswaan',
            'description' => 'Data organisasi kemahasiswaan (ormawa) di Universitas Negeri Yogyakarta',
        ]);

        DataField::create([
            'data_type_id' => $ormawa->id,
            'name' => 'nama_ormawa',
            'label' => 'Nama Organisasi',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $ormawa->id,
            'name' => 'jenis_ormawa',
            'label' => 'Jenis Organisasi',
            'type' => 'dropdown',
            'options' => json_encode([
                'BEM Universitas',
                'BEM Fakultas',
                'DPM Universitas',
                'DPM Fakultas',
                'UKM (Unit Kegiatan Mahasiswa)',
                'Himpunan Mahasiswa Prodi',
                'Komunitas',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 2,
        ]);

        DataField::create([
            'data_type_id' => $ormawa->id,
            'name' => 'ketua',
            'label' => 'Nama Ketua',
            'type' => 'text',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 3,
        ]);

        DataField::create([
            'data_type_id' => $ormawa->id,
            'name' => 'pembimbing',
            'label' => 'Dosen Pembimbing',
            'type' => 'text',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $ormawa->id,
            'name' => 'jumlah_anggota',
            'label' => 'Jumlah Anggota',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $ormawa->id,
            'name' => 'induk',
            'label' => 'Organisasi Induk',
            'type' => 'text',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 6,
        ]);

        DataField::create([
            'data_type_id' => $ormawa->id,
            'name' => 'deskripsi',
            'label' => 'Deskripsi Kegiatan',
            'type' => 'textarea',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 7,
        ]);

        DataField::create([
            'data_type_id' => $ormawa->id,
            'name' => 'logo',
            'label' => 'Logo Organisasi',
            'type' => 'image',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 8,
        ]);

        // ===================== 9. JARINGAN ALUMNI =====================
        $alumni = DataType::create([
            'name' => 'Jaringan Alumni',
            'description' => 'Data jaringan alumni Universitas Negeri Yogyakarta',
        ]);

        DataField::create([
            'data_type_id' => $alumni->id,
            'name' => 'nama',
            'label' => 'Nama Alumni',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $alumni->id,
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
            'data_type_id' => $alumni->id,
            'name' => 'prodi',
            'label' => 'Program Studi',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 3,
        ]);

        DataField::create([
            'data_type_id' => $alumni->id,
            'name' => 'tahun_lulus',
            'label' => 'Tahun Lulus',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $alumni->id,
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $alumni->id,
            'name' => 'pekerjaan',
            'label' => 'Pekerjaan Saat Ini',
            'type' => 'text',
            'required' => true,
            'is_sortable' => false,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 6,
        ]);

        DataField::create([
            'data_type_id' => $alumni->id,
            'name' => 'instansi',
            'label' => 'Instansi / Perusahaan',
            'type' => 'text',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 7,
        ]);

        DataField::create([
            'data_type_id' => $alumni->id,
            'name' => 'alamat',
            'label' => 'Alamat',
            'type' => 'textarea',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 8,
        ]);

        DataField::create([
            'data_type_id' => $alumni->id,
            'name' => 'no_telepon',
            'label' => 'Nomor Telepon',
            'type' => 'text',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 9,
        ]);

        DataField::create([
            'data_type_id' => $alumni->id,
            'name' => 'foto',
            'label' => 'Foto',
            'type' => 'image',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 10,
        ]);

        // ===================== 10. KEUANGAN =====================
        $keuangan = DataType::create([
            'name' => 'Keuangan',
            'description' => 'Data keuangan dan anggaran Universitas Negeri Yogyakarta',
        ]);

        DataField::create([
            'data_type_id' => $keuangan->id,
            'name' => 'tahun_anggaran',
            'label' => 'Tahun Anggaran',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 1,
        ]);

        DataField::create([
            'data_type_id' => $keuangan->id,
            'name' => 'sumber_dana',
            'label' => 'Sumber Dana',
            'type' => 'dropdown',
            'options' => json_encode([
                'APBN - PNBP',
                'APBN - Rupiah Murni',
                'APBN - SBSN',
                'Penerimaan BLU',
                'Hibah',
                'Kerjasama',
                'Lainnya',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 2,
        ]);

        DataField::create([
            'data_type_id' => $keuangan->id,
            'name' => 'jenis_anggaran',
            'label' => 'Jenis Anggaran',
            'type' => 'dropdown',
            'options' => json_encode([
                'Belanja Pegawai',
                'Belanja Barang dan Jasa',
                'Belanja Modal',
                'Belanja Operasional',
                'Belanja Penelitian',
                'Belanja Pengabdian',
                'Belanja Kemahasiswaan',
                'Belanja Investasi',
            ]),
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 3,
        ]);

        DataField::create([
            'data_type_id' => $keuangan->id,
            'name' => 'unit',
            'label' => 'Unit / Fakultas',
            'type' => 'text',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => true,
            'show_in_table' => true,
            'order' => 4,
        ]);

        DataField::create([
            'data_type_id' => $keuangan->id,
            'name' => 'pagu_anggaran',
            'label' => 'Pagu Anggaran (Rp)',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 5,
        ]);

        DataField::create([
            'data_type_id' => $keuangan->id,
            'name' => 'realisasi',
            'label' => 'Realisasi (Rp)',
            'type' => 'number',
            'required' => true,
            'is_sortable' => true,
            'is_filterable' => false,
            'show_in_table' => true,
            'order' => 6,
        ]);

        DataField::create([
            'data_type_id' => $keuangan->id,
            'name' => 'keterangan',
            'label' => 'Keterangan',
            'type' => 'textarea',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 7,
        ]);

        DataField::create([
            'data_type_id' => $keuangan->id,
            'name' => 'file_dokumen',
            'label' => 'File Dokumen',
            'type' => 'file',
            'required' => false,
            'is_sortable' => false,
            'is_filterable' => false,
            'show_in_table' => false,
            'order' => 8,
        ]);

        // ===================== ASSIGN ADMIN TO DATA TYPES =====================
        $adminBerita = User::where('email', 'admin.berita@afdaper.uny.ac.id')->first();
        $adminDosen = User::where('email', 'admin.dosen@afdaper.uny.ac.id')->first();
        $adminMahasiswa = User::where('email', 'admin.mahasiswa@afdaper.uny.ac.id')->first();
        $adminPenelitian = User::where('email', 'admin.penelitian@afdaper.uny.ac.id')->first();
        $adminPengabdian = User::where('email', 'admin.pengabdian@afdaper.uny.ac.id')->first();
        $adminTendik = User::where('email', 'admin.tendik@afdaper.uny.ac.id')->first();
        $adminFasilitas = User::where('email', 'admin.fasilitas@afdaper.uny.ac.id')->first();
        $adminOrmawa = User::where('email', 'admin.ormawa@afdaper.uny.ac.id')->first();
        $adminAlumni = User::where('email', 'admin.alumni@afdaper.uny.ac.id')->first();
        $adminKeuangan = User::where('email', 'admin.keuangan@afdaper.uny.ac.id')->first();

        if ($adminBerita) $adminBerita->dataTypes()->attach($berita->id);
        if ($adminDosen) $adminDosen->dataTypes()->attach($dosen->id);
        if ($adminMahasiswa) $adminMahasiswa->dataTypes()->attach($mahasiswa->id);
        if ($adminPenelitian) $adminPenelitian->dataTypes()->attach($penelitian->id);
        if ($adminPengabdian) $adminPengabdian->dataTypes()->attach($pkm->id);
        if ($adminTendik) $adminTendik->dataTypes()->attach($tendik->id);
        if ($adminFasilitas) $adminFasilitas->dataTypes()->attach($fasilitas->id);
        if ($adminOrmawa) $adminOrmawa->dataTypes()->attach($ormawa->id);
        if ($adminAlumni) $adminAlumni->dataTypes()->attach($alumni->id);
        if ($adminKeuangan) $adminKeuangan->dataTypes()->attach($keuangan->id);
    }
}
