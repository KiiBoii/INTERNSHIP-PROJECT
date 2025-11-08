<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    // Pastikan fillable mencakup semua kolom yang Anda gunakan untuk INSERT
    protected $fillable = [
        'judul',
        'keterangan',
        'file_path',
        'file_name',
    ];
    
    // Pastikan ini adalah nama primary key (default-nya 'id', tapi penting untuk verifikasi)
    protected $primaryKey = 'id'; 
    
    // Pastikan nama tabel adalah 'dokumens' (default Laravel)
    protected $table = 'dokumens'; 

    // Opsional: Untuk kemudahan akses URL download
    public function getDownloadUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}