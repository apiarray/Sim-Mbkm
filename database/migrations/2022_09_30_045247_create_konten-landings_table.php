<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontenLandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konten-landings', function (Blueprint $table) {
            $table->id();           
			$table->enum('jenis', ['banner', 'sambutan', 'pengumuman', 'pendaftaran', 'download', 'info', 'dosen', 'mahasiswa']);
			$table->string('judul')->nullable();
            $table->text('isi')->nullable();
			$table->string('penutup')->nullable();;
			$table->string('gambar')->nullable();;
			$table->string('email')->nullable();		
			$table->date('tanggal');
			$table->smallInteger('aktif');
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
        Schema::dropIfExists('konten-landings');
    }
}
