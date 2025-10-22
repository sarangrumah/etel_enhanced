<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbTrxOssPelacakan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_trx_oss_pelacakan', function (Blueprint $table) {
            $table->id();
            $table->string('alt_id');
            $table->string('oss_id');
            $table->string('id_proyek');
            $table->string('id_izin');
            $table->string('kd_izin');
            $table->string('nama_izin');
            $table->string('jenis_izin');
            $table->string('flag_perpanjangan');
            $table->string('tipe_dokumen');
            $table->string('status');
            $table->string('catatan');
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
        Schema::dropIfExists('tb_trx_oss_pelacakan');
    }
}