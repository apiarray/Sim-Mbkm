<?php

namespace Database\Seeders;

use App\Models\Masters\Fakultas;
use App\Models\Pengguna\DosenDpl;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminDosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataAdmin = [
            [
                'name' => 'Hendra',
                'email' => 'hendra@gmail.com',
                'password' => Hash::make('123123123'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123123'),
            ],
            [
                'name' => 'Devi',
                'email' => 'devi@gmail.com',
                'password' => Hash::make('123123123'),
            ],
        ];

        foreach($dataAdmin as $da){
            User::create($da);
        }

        $dataDosen = [
            [
                'nip' => '1230000',
                'nama' => 'Dosen, S.T',
                'email' => 'dosen@gmail.com',
                'password' => Hash::make('123123123'),
                'fakultas_id' => Fakultas::where('kode', 'FTM')->first()->id
            ],
            [
                'nip' => '1230001',
                'nama' => 'Akbar Pradana, S.Pd.',
                'email' => 'akbarpradana@gmail.com',
                'password' => Hash::make('123123123'),
                'fakultas_id' => Fakultas::where('kode', 'FKIP')->first()->id
            ],
            [
                'nip' => '1230002',
                'nama' => 'Bayu Rizki, S.E.',
                'email' => 'bayurizki@gmail.com',
                'password' => Hash::make('123123123'),
                'fakultas_id' => Fakultas::where('kode', 'FEB')->first()->id
            ],
        ];

        foreach($dataDosen as $dd){
            DosenDpl::create($dd);
        }
    }
}
