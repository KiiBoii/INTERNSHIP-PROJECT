<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Berita extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'user_id',
        'tag', // <-- ▼▼▼ PERBARUAN: Tambahkan 'tag' di sini
    ];

    /**
     * Mendefinisikan relasi bahwa Berita 'dimiliki oleh' (belongsTo) satu User.
     * (Relasi ini sudah benar dari kode Anda)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}