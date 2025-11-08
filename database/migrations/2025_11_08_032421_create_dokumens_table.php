<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_dokumens_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // Judul Dokumen (Contoh: RKA 2024 DINSOS RIAU)
            $table->text('keterangan')->nullable(); // Keterangan (Contoh: RKA 2024 KUA PPAS)
            $table->string('file_path'); // Lokasi file di storage (Wajib ada)
            $table->string('file_name'); // Nama file asli
            $table->timestamps(); // Tanggal Upload
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
