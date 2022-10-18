<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanAkhirDosenDplTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_akhir_dosen_dpl', function (Blueprint $table) {
            $table->id();
            $table->string('id_laporan_akhir_dosen_dpl')->nullable();
            $table->unsignedBigInteger('dosen_dpl_id');
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->date('tanggal_laporan_akhir');
            $table->timestamps();

            $table->foreign('dosen_dpl_id')->references('id')->on('dosen_dpl')->onUpdate('cascade');
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_akhir_dosen_dpl');
    }
}
