<?php

namespace Database\Seeders;

use App\Models\Masters\Semester;
use App\Models\Masters\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSemesterSeeder extends Seeder
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
                'nama' => 'Semester Ganjil'
            ],
            [
                'nama' => 'Semester Genap'
            ],
        ];
        foreach($data as $d){
            Semester::create($d);
        }

        $smstrInserted = Semester::get();
        for($i = 2021; $i <= 2025; $i++){
            foreach($smstrInserted as $d){
                $x = [
                    'semester_id' => $d->id,
                    'tahun_ajaran' => $i,
                    'status' => ($i == date('Y') && (($d->id == 1 && date('n') < 7) || ($d->id == 2 && date('n') > 6))) ? 'aktif' : 'tidak_aktif'
                ];
                TahunAjaran::create($x);
            }
        }
    }
}
