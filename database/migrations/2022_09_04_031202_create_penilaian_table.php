<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bab_penilaian_id');
            $table->mediumText('soal_penilaian');
            $table->float('bobot', 8, 2)->nullable(); // asumsi saat ini bobot hanya per bab dan per jawaban, sehingga nullable
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bab_penilaian_id')->references('id')->on('bab_penilaian')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaian');
    }
}
