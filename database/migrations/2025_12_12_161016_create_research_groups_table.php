<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('research_groups', function (Blueprint $table) {
            $table->id();
            $table->string('nama_group');
            $table->text('deskripsi')->nullable();
            $table->string('ketua')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Update tabel pengabdians - tambah kolom research_group_id
        Schema::table('pengabdians', function (Blueprint $table) {
            $table->unsignedBigInteger('research_group_id')->nullable()->after('bidang_id');
            
            $table->foreign('research_group_id')
                  ->references('id')
                  ->on('research_groups')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pengabdians', function (Blueprint $table) {
            $table->dropForeign(['research_group_id']);
            $table->dropColumn('research_group_id');
        });
        
        Schema::dropIfExists('research_groups');
    }
};