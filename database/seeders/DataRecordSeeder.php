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
        $berita = DataType::where('name', 'Berita UNY')->first();
        $mahasiswa = DataType::where('name', 'Mahasiswa')->first();
        $dosen = DataType::where('name', 'Dosen')->first();

        if (!$berita || !$mahasiswa || !$dosen) {
            $this->command->warn('Data types not found. Run DataTypeSeeder first.');
            return;
        }

        // Sample Berita
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

        // Sample Mahasiswa
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

        // Sample Dosen
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