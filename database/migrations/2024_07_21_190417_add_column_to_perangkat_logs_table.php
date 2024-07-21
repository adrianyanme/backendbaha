<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('perangkat_logs', function (Blueprint $table) {
            $table->string('username')->nullable();
            $table->string('nama_perangkat')->nullable(); // Ganti 'new_column' dengan nama kolom yang diinginkan
        });
    }

    public function down()
    {
        Schema::table('perangkat_logs', function (Blueprint $table) {
            $table->dropColumn('username'); 
            $table->dropColumn('nama_perangkat'); // Ganti 'new_column' dengan nama kolom yang diinginkan
        });
    }
};
