<?php

namespace Database\Seeders;

use App\Models\Aktivitas\RegistrasiMbkm;
use App\Models\Masters\Kelas;
use App\Models\Masters\Program;
use App\Models\Masters\TahunAjaran;
use App\Models\Pengguna\DosenDpl;
use App\Models\Pengguna\Mahasiswa;
use Illuminate\Database\Seeder;

class DummyRegistrasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i<=5; $i++){
            $rand = rand(0,2);
            $data = [
                'id_registrasi' => $rand == 1 ? generateRandomString(5, 4) : NULL,
                'mahasiswa_id' => Mahasiswa::inRandomOrder()->first()->id,
                'program_id' => Program::inRandomOrder()->first()->id,
                'tahun_ajaran_id' => TahunAjaran::inRandomOrder()->first()->id,
                'kelas_id' => Kelas::inRandomOrder()->first()->id,
                'dosen_dpl_id' => $rand == 1 ? DosenDpl::inRandomOrder()->first()->id : NULL,
                'tanggal_registrasi' => date('Y-m-d H:i:s'),
                'tanggal_validasi' => $rand == 1 ? date('Y-m-d H:i:s') : NULL,
                'status_validasi' => $rand === 0 ? 'mengajukan' : ($rand == 1 ? 'tervalidasi' : 'batal'),
            ];

            RegistrasiMbkm::create($data);
        }
    }
}
