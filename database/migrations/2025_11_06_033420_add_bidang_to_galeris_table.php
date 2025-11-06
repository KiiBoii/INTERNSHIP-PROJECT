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
    Schema::table('galeris', function (Blueprint $table) {
        // Tambahkan kolom 'bidang' setelah 'judul_kegiatan'
        $table->string('bidang')->nullable()->after('judul_kegiatan');
    });
}

public function down(): void
{
    Schema::table('galeris', function (Blueprint $table) {
        $table->dropColumn('bidang');
    });
}
};
