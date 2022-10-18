<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogbookMingguan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbook_mingguan', function (Blueprint $table) {
            $table->id();
            $table->string('id_log_mingguan')->nullable()->comment('Diisi ketika melakukan validasi');
            $table->unsignedTinyInteger('minggu');
            $table->date('tanggal')->nullable();
            $table->unsignedBigInteger('registrasi_mbkm_id');
            $table->mediumText('link_dokumen')->nullable();
            $table->mediumText('link_video')->nullable();
            $table->mediumText('link_youtube')->nullable();
            $table->tinyText('judul');
            $table->longText('deskripsi');
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
        Schema::dropIfExists('logbook_mingguan');
    }
}
