<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetilPeminjaman extends Model
{
    protected $table = 'detil_peminjamans';
    
    protected $fillable = [
        'id_peminjaman',
        'id_buku',
    ];

    // Relasi dengan peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    // Relasi dengan buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}