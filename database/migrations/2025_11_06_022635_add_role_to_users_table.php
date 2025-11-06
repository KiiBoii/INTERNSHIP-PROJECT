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
        Schema::table('users', function (Blueprint $table) {
            // --- TAMBAHKAN BARIS INI ---
            // Menambahkan kolom 'role'
            // 'admin' bisa akses semua, 'berita' hanya akses berita
            $table->string('role')->default('berita')->after('email'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // --- TAMBAHKAN BARIS INI ---
            // Untuk menghapus kolom jika migration di-rollback
            $table->dropColumn('role');
        });
    }
};
