<?php

namespace Database\Seeders;

use App\Models\Pengguna\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nim' => '012300001',
                'nama' => 'Andi MHS1',
                'email' => 'mahasiswa1@gmail.com',
                'password' => Hash::make('123123123'),
                'tahun_masuk' => 2022,
                'status' => 'internal',
                'jenis_pendaftaran' => 'baru',
                'jenis_kelamin' => 'pria',
            ],
            [
                'nim' => '012300002',
                'nama' => 'Bayu MHS2',
                'email' => 'mahasiswa2@gmail.com',
                'password' => Hash::make('123123123'),
                'tahun_masuk' => 2022,
                'status' => 'internal',
                'jenis_pendaftaran' => 'baru',
                'jenis_kelamin' => 'pria',
            ],
            [
                'nim' => '012300003',
                'nama' => 'Citra MHS3',
                'email' => 'mahasiswa3@gmail.com',
                'password' => Hash::make('123123123'),
                'tahun_masuk' => 2022,
                'status' => 'internal',
                'jenis_pendaftaran' => 'baru',
                'jenis_kelamin' => 'wanita',
            ],
            [
                'nim' => '012300004',
                'nama' => 'Dea MHS4',
                'email' => 'mahasiswa4@gmail.com',
                'password' => Hash::make('123123123'),
                'tahun_masuk' => 2022,
                'status' => 'internal',
                'jenis_pendaftaran' => 'baru',
                'jenis_kelamin' => 'wanita',
            ],
        ];

        foreach($data as $d){
            Mahasiswa::create($d);
        }
    }
}
