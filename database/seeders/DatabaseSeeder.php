<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(KotaKabupatenProvinsiSeeder::class);
        $this->call(ProgramSeeder::class);
        $this->call(BabPenilaianSeeder::class);
        $this->call(JenjangFakultasJurusanSeeder::class);
        $this->call(TahunAjaranSemesterSeeder::class);
        $this->call(IdentitasUniversitasSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(AdminDosenSeeder::class);
        $this->call(DummyMahasiswaSeeder::class);
        $this->call(DummyRegistrasiSeeder::class);
    }
}
