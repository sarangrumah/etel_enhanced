<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_trans', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->after('log_additionalinfo');
            $table->string('user_agent')->nullable()->after('ip_address');
            $table->string('url')->nullable()->after('user_agent');
            $table->text('data_before')->nullable()->after('url');
            $table->text('data_after')->nullable()->after('data_before');
            $table->string('log_action')->nullable()->after('data_after');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_trans', function (Blueprint $table) {
            $table->dropColumn('ip_address');
            $table->dropColumn('user_agent');
            $table->dropColumn('url');
            $table->dropColumn('data_before');
            $table->dropColumn('data_after');
            $table->dropColumn('log_action');
        });
    }
};
