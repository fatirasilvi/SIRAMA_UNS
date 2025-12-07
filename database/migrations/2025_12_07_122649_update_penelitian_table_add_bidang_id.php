<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penelitians', function (Blueprint $table) {
            // Tambah kolom bidang_id
            $table->unsignedBigInteger('bidang_id')->nullable()->after('judul');
            
            // Foreign key
            $table->foreign('bidang_id')
                  ->references('id')
                  ->on('bidang')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('penelitians', function (Blueprint $table) {
            $table->dropForeign(['bidang_id']);
            $table->dropColumn('bidang_id');
        });
    }
};