<?php

namespace Database\Seeders;

use App\Models\Masters\Jurusan;
use App\Models\Masters\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusan = Jurusan::get();

        foreach($jurusan as $j){
            for($i = 1; $i <= 3; $i++){
                $x = [
                    'nama' => $j->kode . '-' . $i,
                    'jurusan_id' => $j->id
                ];
                Kelas::create($x);
            }
        }
    }
}
