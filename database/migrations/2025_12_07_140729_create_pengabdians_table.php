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
        Schema::create('pengabdians', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dosen_id');   // sama seperti penelitian
            $table->string('judul');
            $table->string('bidang');                 // untuk fallback
            $table->unsignedBigInteger('bidang_id')->nullable();
            $table->integer('tahun');
            $table->text('abstrak')->nullable();
            $table->string('file_path')->nullable();

            $table->enum('status', ['Menunggu Validasi', 'Disetujui', 'Ditolak'])
                  ->default('Menunggu Validasi');

            $table->timestamps();

            // ✅ FOREIGN KEY KE TABEL DOSEN (SAMA SEPERTI PENELITIAN)
            $table->foreign('dosen_id')
                  ->references('id')
                  ->on('dosen')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengabdians');
    }
};
