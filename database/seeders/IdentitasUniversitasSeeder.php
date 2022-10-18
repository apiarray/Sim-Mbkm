<?php

namespace Database\Seeders;

use App\Models\IdentitasUniversitas;
use Illuminate\Database\Seeder;

class IdentitasUniversitasSeeder extends Seeder
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
                'property' => 'nama_universitas',
                'value' => 'Universitas Wisnuwardhana Malang'
            ],
        ];

        foreach($data as $d){
            IdentitasUniversitas::create($d);
        }
    }
}
