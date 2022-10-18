<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRegistrasiMbkmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrasi_mbkm', function (Blueprint $table) {
            $table->id();
            $table->string('id_registrasi', 50)->nullable();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->unsignedBigInteger('kelas_id')->nullable()->comment('Diisi ketika divalidasi oleh admin');
            $table->unsignedBigInteger('dosen_dpl_id')->nullable()->comment('Diisi ketika divalidasi oleh admin');
            $table->timestamp('tanggal_registrasi')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('tanggal_validasi')->nullable();
            $table->enum('status_validasi', ['mengajukan', 'tervalidasi', 'batal'])->default('mengajukan');
            $table->mediumText('lampiran')->nullable();
            $table->mediumText('file_khs')->nullable();
            $table->mediumText('file_krs')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onUpdate('cascade');
            $table->foreign('program_id')->references('id')->on('program')->onUpdate('cascade');
            $table->foreign('dosen_dpl_id')->references('id')->on('dosen_dpl')->onUpdate('cascade');
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran')->onUpdate('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrasi_mbkm');
    }
}
