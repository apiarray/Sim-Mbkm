<?php

namespace Database\Seeders;

use App\Models\Masters\Fakultas;
use App\Models\Masters\Jenjang;
use App\Models\Masters\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenjangFakultasJurusanSeeder extends Seeder
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
                'nama' => 'Diploma 3',
                'kode' => 'D3',
                'fakultas' => [
                    'kode' => 'FTM',
                    'nama' => 'Fakultas Teknik Mesin'
                ],
                'jurusan' => [
                    [
                        'kode' => 'Tekmes',
                        'nama' => 'Teknik Mesin'
                    ],
                    [
                        'kode' => 'Tekind',
                        'nama' => 'Teknik Industri'
                    ],
                ],
            ],
            [
                'nama' => 'Strata 1',
                'kode' => 'S1',
                'fakultas' => [
                    'kode' => 'FKIP',
                    'nama' => 'Fakultas Keguruan dan Ilmu Pendidikan'
                ],
                'jurusan' => [
                    [
                        'kode' => 'Penkim',
                        'nama' => 'Pendidikan Kimia'
                    ],
                    [
                        'kode' => 'Penfis',
                        'nama' => 'Pendidikan Fisika'
                    ],
                ]
            ],
            [
                'nama' => 'Pascasarjana',
                'kode' => 'S2',
                'fakultas' => [
                    'kode' => 'FEB',
                    'nama' => 'Fakultas Ekonomi dan Bisnis'
                ],
                'jurusan' => [
                    [
                        'kode' => 'Manbis',
                        'nama' => 'Manajemen Bisnis'
                    ],
                    [
                        'kode' => 'Ekopem',
                        'nama' => 'Ekonomi Pembangunan'
                    ],
                ]
            ],
        ];

        DB::beginTransaction();
        foreach($data as $d){
            $dataJenjang = [
                'nama' => $d['nama'],
                'kode' => $d['kode'],
            ];
            $insertJenjang = Jenjang::create($dataJenjang);

            $dataFakultas = $d['fakultas'];
            $dataFakultas['jenjang_id'] = $insertJenjang->id;
            $insertFakultas = Fakultas::create($dataFakultas);

            foreach($d['jurusan'] as $j){
                $dataJurusan = $j;
                $dataJurusan['fakultas_id'] = $insertFakultas->id;
                Jurusan::create($dataJurusan);
            }
        }
        DB::commit();
    }
}
