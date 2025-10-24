<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesForPerformance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_oss_trx_izin', function (Blueprint $table) {
            $table->index('id_izin');
            $table->index('oss_id');
            $table->index('kd_izin');
            $table->index('status_checklist');
        });

        Schema::table('tb_trx_persyaratan', function (Blueprint $table) {
            $table->index('id_trx_izin');
        });

        Schema::table('tb_mst_izinlayanan', function (Blueprint $table) {
            $table->index('kode_izin');
        });

        Schema::table('tb_trx_kode_akses', function (Blueprint $table) {
            $table->index('id_izin');
            $table->index('status_permohonan');
        });

        Schema::table('tb_trx_ulo_log', function (Blueprint $table) {
            $table->index('id_izin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_oss_trx_izin', function (Blueprint $table) {
            $table->dropIndex(['id_izin']);
            $table->dropIndex(['oss_id']);
            $table->dropIndex(['kd_izin']);
            $table->dropIndex(['status_checklist']);
        });

        Schema::table('tb_trx_persyaratan', function (Blueprint $table) {
            $table->dropIndex(['id_trx_izin']);
        });

        Schema::table('tb_mst_izinlayanan', function (Blueprint $table) {
            $table->dropIndex(['kode_izin']);
        });

        Schema::table('tb_trx_kode_akses', function (Blueprint $table) {
            $table->dropIndex(['id_izin']);
            $table->dropIndex(['status_permohonan']);
        });

        Schema::table('tb_trx_ulo_log', function (Blueprint $table) {
            $table->dropIndex(['id_izin']);
        });
    }
}
