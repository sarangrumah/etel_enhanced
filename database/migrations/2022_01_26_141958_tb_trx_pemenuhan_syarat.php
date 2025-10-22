<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbTrxPemenuhanSyarat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_trx_pemenuhan_syarat', function (Blueprint $table) {
            $table->id();
            $table->string('alt_id');
            $table->string('kd_izin');
            $table->string('uraian');
            $table->string('jenis_isian');
            $table->string('isian_pemohoan');
            $table->string('koreksi');
            $table->string('catatan');
            $table->string('status');
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
        Schema::dropIfExists('tb_trx_pemenuhan_syarat');
    }
}
