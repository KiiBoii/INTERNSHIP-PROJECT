<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
    'nama',
    'status_pengirim',
    'isi_pengaduan',
    'foto_pengadu',
    'email' 
];
}
