<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanAkhirMahasiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_akhir_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('id_laporan_akhir_mahasiswa')->nullable();
            $table->unsignedBigInteger('registrasi_mbkm_id');
            $table->mediumText('materi_pdf')->nullable();
            $table->mediumText('link_video')->nullable();
            $table->mediumText('link_youtube')->nullable();
            $table->string('judul_materi');
            $table->string('deskripsi');
            $table->date('tanggal_laporan_akhir');
            $table->enum('status_laporan_akhir', ['ajukan_validasi_dpl', 'revisi_dpl', 'validasi'])->default('ajukan_validasi_dpl');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_akhir_mahasiswa');
    }
}
