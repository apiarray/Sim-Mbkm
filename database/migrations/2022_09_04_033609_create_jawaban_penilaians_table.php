<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanPenilaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penilaian_dosen_dpl_id');
            $table->unsignedBigInteger('penilaian_id')->comment('Diisi sesuai penilaian_id dari pilihan_penilaian_id');
            $table->unsignedBigInteger('pilihan_penilaian_id');
            $table->float('bobot', 8, 2)->comment('Diambil dari bab_penilaian');
            $table->float('nilai', 8, 2)->comment('Diambil dari pilihan_penilaian');
            $table->timestamps();

            $table->foreign('penilaian_dosen_dpl_id')->references('id')->on('penilaian_dosen_dpl')->onUpdate('cascade');
            $table->foreign('penilaian_id')->references('id')->on('penilaian')->onUpdate('cascade');
            $table->foreign('pilihan_penilaian_id')->references('id')->on('pilihan_penilaian')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_penilaian');
    }
}
