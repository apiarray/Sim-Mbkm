<?php

namespace Database\Seeders;

use App\Models\Masters\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
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
                'nama' => 'Program A'
            ],
            [
                'nama' => 'Program B'
            ],
            [
                'nama' => 'Program C'
            ],
        ];

        foreach($data as $d){
            Program::create($d);
        }
    }
}
