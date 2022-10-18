<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanAkhirDosenDplDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_akhir_dosen_dpl_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporan_akhir_dosen_dpl_id');
            $table->unsignedBigInteger('registrasi_mbkm_id');
            $table->float('beban_jam_log_harian')->default(0);
            $table->float('beban_jam_log_mingguan')->default(0);
            $table->float('beban_jam_laporan_akhir')->default(0);
            $table->timestamps();

            $table->foreign('laporan_akhir_dosen_dpl_id', 'foreign_laporan_akhir_dosen_dpl_id')->references('id')->on('laporan_akhir_dosen_dpl')->onUpdate('cascade');
            $table->foreign('registrasi_mbkm_id')->references('id')->on('registrasi_mbkm')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_akhir_dosen_dpl_detail');
    }
}
