<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DosenDPL extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_dpl', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50);
            $table->string('nama');
            $table->string('email');
            $table->string('password');
            $table->string('no_telp', 25)->nullable();
            $table->unsignedBigInteger('fakultas_id');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fakultas_id')->references('id')->on('fakultas')->onUpdate('cascade');
            $table->index('nama');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosen_dpl');
    }
}
