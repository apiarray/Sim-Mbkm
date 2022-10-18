<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianDosenDplTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_dosen_dpl', function (Blueprint $table) {
            $table->id();
            $table->string('id_penilaian')->nullable()->comment('Diisi ketika melakukan validasi');
            $table->unsignedBigInteger('registrasi_mbkm_id');
            $table->date('tanggal_penilaian')->nullable();
            $table->float('nilai_raw', 8, 2)->default(0)->comment('Auto sum dari jawaban_penilaian dengan perhitungan bobot');
            $table->float('nilai', 8, 2)->default(0)->comment('Penyesuaian dari nilai_raw');
            $table->enum('status', ['mengajukan', 'dalam_proses', 'revisi', 'tervalidasi'])->default('mengajukan');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('penilaian_dosen_dpl');
    }
}
