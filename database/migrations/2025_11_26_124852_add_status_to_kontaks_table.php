<?php

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
        Schema::table('kontaks', function (Blueprint $table) {
            // Menambahkan kolom status dengan default 'diajukan'
            // Opsi: diajukan, diproses, diterima, ditolak, selesai
            $table->string('status')->default('diajukan')->after('isi_pengaduan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kontaks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};