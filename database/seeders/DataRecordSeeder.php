<?php

namespace Database\Seeders;

use App\Models\DataRecord;
use App\Models\DataType;
use App\Models\DataRecordValue;
use Illuminate\Database\Seeder;

class DataRecordSeeder extends Seeder
{
    public function run(): void
    {
        $berita = DataType::where('name', 'Berita')->first();
        $mahasiswa = DataType::where('name', 'Mahasiswa')->first();
        $dosen = DataType::where('name', 'Dosen')->first();
        $penelitian = DataType::where('name', 'Penelitian')->first();
        $pkm = DataType::where('name', 'Pengabdian kepada Masyarakat')->first();
        $tendik = DataType::where('name', 'Tenaga Kependidikan')->first();
        $fasilitas = DataType::where('name', 'Fasilitas')->first();
        $ormawa = DataType::where('name', 'Organisasi Kemahasiswaan')->first();
        $alumni = DataType::where('name', 'Jaringan Alumni')->first();
        $keuangan = DataType::where('name', 'Keuangan')->first();

        if (!$berita || !$mahasiswa || !$dosen) {
            $this->command->warn('Data types not found. Run DataTypeSeeder first.');
            return;
        }

        // ======================== BERITA ========================
        $berita1 = DataRecord::create(['data_type_id' => $berita->id, 'created_by' => 2]);
        $this->setValues($berita1, [
            'judul' => 'UNY Raih Akreditasi Unggul dari BAN-PT',
            'excerpt' => 'Universitas Negeri Yogyakarta berhasil meraih akreditasi institusi unggul dari BAN-PT untuk periode 2024-2028.',
            'author' => 'Humas UNY',
            'content' => 'Universitas Negeri Yogyakarta (UNY) kembali menorehkan prestasi membanggakan dengan meraih akreditasi institusi dengan predikat "Unggul" dari Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT). Pencapaian ini merupakan hasil kerja keras seluruh sivitas akademika UNY dalam meningkatkan mutu pendidikan, penelitian, dan pengabdian kepada masyarakat.',
            'kategori' => 'Akademik',
            'tanggal_publikasi' => '2024-01-15',
        ]);

        $berita2 = DataRecord::create(['data_type_id' => $berita->id, 'created_by' => 2]);
        $this->setValues($berita2, [
            'judul' => 'Mahasiswa UNY Juara 1 Kompetisi Robot Nasional',
            'excerpt' => 'Tim robotika UNY berhasil menyabet juara 1 dalam ajang Kompetisi Robot Nasional (KRN) 2024.',
            'author' => 'Humas UNY',
            'content' => 'Tim robotika dari Fakultas Teknik UNY berhasil meraih juara 1 dalam Kompetisi Robot Nasional yang diselenggarakan di Jakarta. Tim yang terdiri dari 5 mahasiswa ini mengembangkan robot berkaki yang mampu melewati berbagai rintangan dengan sempurna.',
            'kategori' => 'Kemahasiswaan',
            'tanggal_publikasi' => '2024-02-20',
        ]);

        $berita3 = DataRecord::create(['data_type_id' => $berita->id, 'created_by' => 2]);
        $this->setValues($berita3, [
            'judul' => 'Penelitian Dosen UNY Masuk Jurnal Internasional Bereputasi',
            'excerpt' => 'Penelitian dosen UNY di bidang kecerdasan buatan berhasil dipublikasikan di jurnal internasional bereputasi Q1.',
            'author' => 'Humas UNY',
            'content' => 'Sebuah penelitian inovatif dari dosen Fakultas Teknik UNY di bidang kecerdasan buatan dan machine learning berhasil dipublikasikan di jurnal internasional bereputasi tinggi dengan indeks Scopus Q1. Penelitian ini membahas pengembangan algoritma baru untuk deteksi dini penyakit tanaman menggunakan computer vision.',
            'kategori' => 'Penelitian',
            'tanggal_publikasi' => '2024-03-10',
        ]);

        // ======================== MAHASISWA ========================
        $mhs1 = DataRecord::create(['data_type_id' => $mahasiswa->id, 'created_by' => 3]);
        $this->setValues($mhs1, [
            'nama' => 'Andi Pratama',
            'nim' => '21520241001',
            'email' => 'andi.pratama@student.uny.ac.id',
            'prodi' => 'Pendidikan Teknik Informatika',
            'angkatan' => '2021',
        ]);

        $mhs2 = DataRecord::create(['data_type_id' => $mahasiswa->id, 'created_by' => 3]);
        $this->setValues($mhs2, [
            'nama' => 'Siti Nurhaliza',
            'nim' => '22520241002',
            'email' => 'siti.nurhaliza@student.uny.ac.id',
            'prodi' => 'Teknik Informatika',
            'angkatan' => '2022',
        ]);

        $mhs3 = DataRecord::create(['data_type_id' => $mahasiswa->id, 'created_by' => 3]);
        $this->setValues($mhs3, [
            'nama' => 'Budi Santoso',
            'nim' => '20520241003',
            'email' => 'budi.santoso@student.uny.ac.id',
            'prodi' => 'Manajemen',
            'angkatan' => '2020',
        ]);

        // ======================== DOSEN ========================
        $dsn1 = DataRecord::create(['data_type_id' => $dosen->id, 'created_by' => 4]);
        $this->setValues($dsn1, [
            'nama' => 'Prof. Dr. Ahmad Fauzi, M.Pd.',
            'nip' => '197501012005011001',
            'email' => 'ahmad.fauzi@uny.ac.id',
            'bidang_keahlian' => 'Kecerdasan Buatan',
            'jabatan_fungsional' => 'Guru Besar',
        ]);

        $dsn2 = DataRecord::create(['data_type_id' => $dosen->id, 'created_by' => 4]);
        $this->setValues($dsn2, [
            'nama' => 'Dr. Ratna Dewi, M.Kom.',
            'nip' => '198003012010012002',
            'email' => 'ratna.dewi@uny.ac.id',
            'bidang_keahlian' => 'Sistem Informasi',
            'jabatan_fungsional' => 'Lektor Kepala',
        ]);

        $dsn3 = DataRecord::create(['data_type_id' => $dosen->id, 'created_by' => 4]);
        $this->setValues($dsn3, [
            'nama' => 'Dr. Hendra Gunawan, M.T.',
            'nip' => '198506012015011003',
            'email' => 'hendra.gunawan@uny.ac.id',
            'bidang_keahlian' => 'Jaringan Komputer',
            'jabatan_fungsional' => 'Lektor',
        ]);

        // ======================== PENELITIAN ========================
        if ($penelitian) {
            $r1 = DataRecord::create(['data_type_id' => $penelitian->id, 'created_by' => 5]);
            $this->setValues($r1, [
                'judul_penelitian' => 'Pengembangan Sistem Deteksi Dini Penyakit Tanaman menggunakan Deep Learning',
                'ketua_peneliti' => 'Dr. Ratna Dewi, M.Kom.',
                'sumber_dana' => 'Hibah DIKTI',
                'dana' => '150000000',
                'tahun' => '2024',
            ]);

            $r2 = DataRecord::create(['data_type_id' => $penelitian->id, 'created_by' => 5]);
            $this->setValues($r2, [
                'judul_penelitian' => 'Analisis Sentimen Media Sosial untuk Pemetaan Opini Publik',
                'ketua_peneliti' => 'Dr. Hendra Gunawan, M.T.',
                'sumber_dana' => 'Hibah Internal UNY',
                'dana' => '75000000',
                'tahun' => '2024',
            ]);
        }

        // ======================== PENGABDIAN KEPADA MASYARAKAT ========================
        if ($pkm) {
            $p1 = DataRecord::create(['data_type_id' => $pkm->id, 'created_by' => 6]);
            $this->setValues($p1, [
                'judul_kegiatan' => 'Pelatihan Literasi Digital bagi Guru SD di Gunungkidul',
                'ketua_pelaksana' => 'Prof. Dr. Ahmad Fauzi, M.Pd.',
                'lokasi' => 'Gunungkidul, DIY',
                'mitra' => 'SD N 1 Playen',
                'sumber_dana' => 'Hibah Kemendikbudristek',
                'dana' => '50000000',
                'tahun' => '2024',
            ]);

            $p2 = DataRecord::create(['data_type_id' => $pkm->id, 'created_by' => 6]);
            $this->setValues($p2, [
                'judul_kegiatan' => 'Pengembangan Sistem Informasi Desa di Kecamatan Temanggung',
                'ketua_pelaksana' => 'Dr. Ratna Dewi, M.Kom.',
                'lokasi' => 'Temanggung, Jawa Tengah',
                'mitra' => 'Pemerintah Desa Madureso',
                'sumber_dana' => 'Mandiri',
                'dana' => '25000000',
                'tahun' => '2024',
            ]);
        }

        // ======================== TENAGA KEPENDIDIKAN ========================
        if ($tendik) {
            $t1 = DataRecord::create(['data_type_id' => $tendik->id, 'created_by' => 7]);
            $this->setValues($t1, [
                'nama' => 'Supardi, A.Md.',
                'nip' => '198512012010121001',
                'email' => 'supardi@uny.ac.id',
                'unit_kerja' => 'Fakultas Teknik',
                'jabatan' => 'Staf Administrasi Akademik',
                'pendidikan_terakhir' => 'D3',
            ]);

            $t2 = DataRecord::create(['data_type_id' => $tendik->id, 'created_by' => 7]);
            $this->setValues($t2, [
                'nama' => 'Dwi Wahyuni, S.E.',
                'nip' => '199002012012122002',
                'email' => 'dwi.wahyuni@uny.ac.id',
                'unit_kerja' => 'Rektorat',
                'jabatan' => 'Bendahara',
                'pendidikan_terakhir' => 'S1',
            ]);
        }

        // ======================== FASILITAS ========================
        if ($fasilitas) {
            $f1 = DataRecord::create(['data_type_id' => $fasilitas->id, 'created_by' => 8]);
            $this->setValues($f1, [
                'nama_fasilitas' => 'Gedung Kuliah Bersama FT',
                'jenis' => 'Gedung',
                'lokasi' => 'Fakultas Teknik, Kampus Karangmalang',
                'kondisi' => 'Baik',
                'jumlah' => '1',
                'tahun_pengadaan' => '2019',
            ]);

            $f2 = DataRecord::create(['data_type_id' => $fasilitas->id, 'created_by' => 8]);
            $this->setValues($f2, [
                'nama_fasilitas' => 'Laboratorium Komputer',
                'jenis' => 'Laboratorium',
                'lokasi' => 'Gedung FT Lantai 3',
                'kondisi' => 'Baik',
                'jumlah' => '2',
                'tahun_pengadaan' => '2022',
            ]);
        }

        // ======================== ORGANISASI KEMAHASISWAAN ========================
        if ($ormawa) {
            $o1 = DataRecord::create(['data_type_id' => $ormawa->id, 'created_by' => 9]);
            $this->setValues($o1, [
                'nama_ormawa' => 'BEM Fakultas Teknik',
                'jenis_ormawa' => 'BEM Fakultas',
                'ketua' => 'Andi Pratama',
                'pembimbing' => 'Dr. Ratna Dewi, M.Kom.',
                'jumlah_anggota' => '45',
                'induk' => 'BEM Universitas',
            ]);

            $o2 = DataRecord::create(['data_type_id' => $ormawa->id, 'created_by' => 9]);
            $this->setValues($o2, [
                'nama_ormawa' => 'Robot Club UNY',
                'jenis_ormawa' => 'UKM (Unit Kegiatan Mahasiswa)',
                'ketua' => 'Budi Santoso',
                'pembimbing' => 'Dr. Hendra Gunawan, M.T.',
                'jumlah_anggota' => '30',
                'induk' => 'Fakultas Teknik',
            ]);
        }

        // ======================== JARINGAN ALUMNI ========================
        if ($alumni) {
            $a1 = DataRecord::create(['data_type_id' => $alumni->id, 'created_by' => 10]);
            $this->setValues($a1, [
                'nama' => 'Rizky Firmansyah',
                'nim' => '18520241001',
                'prodi' => 'Teknik Informatika',
                'tahun_lulus' => '2022',
                'email' => 'rizky.firmansyah@gmail.com',
                'pekerjaan' => 'Software Engineer',
                'instansi' => 'PT Gojek Indonesia',
                'no_telepon' => '081234567891',
            ]);

            $a2 = DataRecord::create(['data_type_id' => $alumni->id, 'created_by' => 10]);
            $this->setValues($a2, [
                'nama' => 'Fitri Handayani',
                'nim' => '18520241002',
                'prodi' => 'Pendidikan Teknik Informatika',
                'tahun_lulus' => '2022',
                'email' => 'fitri.handayani@gmail.com',
                'pekerjaan' => 'Guru Informatika',
                'instansi' => 'SMK N 2 Yogyakarta',
                'no_telepon' => '081234567892',
            ]);
        }

        // ======================== KEUANGAN ========================
        if ($keuangan) {
            $k1 = DataRecord::create(['data_type_id' => $keuangan->id, 'created_by' => 11]);
            $this->setValues($k1, [
                'tahun_anggaran' => '2024',
                'sumber_dana' => 'APBN - Rupiah Murni',
                'jenis_anggaran' => 'Belanja Operasional',
                'unit' => 'Fakultas Teknik',
                'pagu_anggaran' => '5000000000',
                'realisasi' => '4250000000',
            ]);

            $k2 = DataRecord::create(['data_type_id' => $keuangan->id, 'created_by' => 11]);
            $this->setValues($k2, [
                'tahun_anggaran' => '2024',
                'sumber_dana' => 'APBN - PNBP',
                'jenis_anggaran' => 'Belanja Penelitian',
                'unit' => 'LPPM',
                'pagu_anggaran' => '2000000000',
                'realisasi' => '1750000000',
            ]);
        }
    }

    private function setValues(DataRecord $record, array $values): void
    {
        $dataType = $record->dataType;
        $fields = $dataType->fields;

        foreach ($fields as $field) {
            if (isset($values[$field->name])) {
                DataRecordValue::create([
                    'data_record_id' => $record->id,
                    'data_field_id' => $field->id,
                    'value' => $values[$field->name],
                ]);
            }
        }
    }
}
