<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('dosen', function (Blueprint $table) {
            if (!Schema::hasColumn('dosen', 'prodi')) {
                $table->string('prodi')->nullable();
            }

            if (!Schema::hasColumn('dosen', 'jabatan')) {
                $table->string('jabatan')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('dosen', function (Blueprint $table) {
            $table->dropColumn(['prodi', 'jabatan']);
        });
    }
};
