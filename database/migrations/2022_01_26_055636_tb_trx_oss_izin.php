<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbTrxOssIzin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_trx_oss_izin', function (Blueprint $table) {
            $table->id();
            $table->string('oss_id');
            $table->string('id_produk')->nullable();
            $table->string('id_proyek')->nullable();
            $table->string('id_izin')->nullable();
            $table->string('jenis_izin')->nullable();
            $table->string('kd_izin')->nullable();
            $table->string('kd_daerah')->nullable();
            $table->string('nama_izin')->nullable();
            $table->string('no_izin')->nullable();
            $table->string('tgl_izin')->nullable();
            $table->string('instansi')->nullable();
            $table->string('id_bidang_spesifik')->nullable();
            $table->string('bidang_spesifik')->nullable();
            $table->string('id_kewenangan')->nullable();
            $table->string('parameter_kewenangan')->nullable();
            $table->string('kewenangan')->nullable();
            $table->string('file_izin')->nullable();
            $table->string('file_izin_oss')->nullable();
            $table->string('flag_checklist')->nullable();
            $table->string('status_checklist')->nullable();
            $table->string('flag_transaksional')->nullable();
            $table->string('flag_perpanjangan')->nullable();
            $table->string('kd_dokumen')->nullable();
            $table->string('nm_dokumen')->nullable();
            $table->string('status')->nullable()->default('0');
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
        Schema::dropIfExists('tb_trx_oss_izin');
    }
}
