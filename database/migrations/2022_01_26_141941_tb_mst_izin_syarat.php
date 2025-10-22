<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbMstIzinSyarat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_mst_izin_syarat', function (Blueprint $table) {
            $table->id();
            $table->string('alt_id');
            $table->string('kbli');
            $table->string('kib');
            $table->string('uraian');
            $table->string('jenis_isian');
            $table->string('flag_opsional');
            $table->string('file_lampiran');
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
        Schema::dropIfExists('tb_mst_izin_syarat');
    }
}