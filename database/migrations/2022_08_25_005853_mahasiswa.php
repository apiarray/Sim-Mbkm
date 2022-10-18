<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Mahasiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 50)->unique();
            $table->string('nama');
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->smallInteger('tahun_masuk');
            $table->enum('status', ['internal', 'luar_unidha'])->default('internal');
            $table->enum('jenis_pendaftaran', ['baru', 'pindahan'])->default('baru');
            
            // data diri mahasiswa
            $table->string('email_kampus')->nullable();
            $table->string('nik', 50)->nullable();
            $table->string('agama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->string('alamat')->nullable();
            $table->string('alamat_rt', 5)->nullable();
            $table->string('alamat_rw', 5)->nullable();
            $table->string('alamat_dusun')->nullable();
            $table->string('alamat_desa_kelurahan')->nullable();
            $table->string('alamat_kecamatan')->nullable();
            $table->unsignedBigInteger('alamat_kota_id')->nullable();
            $table->string('alamat_kode_pos')->nullable();
            $table->string('asal_instansi')->nullable();
            $table->string('nisn')->nullable();
            $table->enum('jenis_kelamin', ['pria', 'wanita']);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('nama');
            $table->foreign('alamat_kota_id')->references('id')->on('kota_kabupaten')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
