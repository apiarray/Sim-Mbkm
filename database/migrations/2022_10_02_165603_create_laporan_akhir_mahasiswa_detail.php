<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanAkhirMahasiswaDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_akhir_mahasiswa_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporan_akhir_mahasiswa_id');
            $table->unsignedBigInteger('id_log_book_mingguan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_akhir_mahasiswa_detail');
    }
}
