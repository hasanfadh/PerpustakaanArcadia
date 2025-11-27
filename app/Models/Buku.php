<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';
    protected $primaryKey = 'id_buku';
    
    protected $fillable = [
        'judul_buku',
        'tgl_terbit',
        'nama_pengarang',
        'nama_penerbit',
    ];

    protected $casts = [
        'tgl_terbit' => 'date',
    ];

    // Relasi many-to-many dengan peminjaman melalui detil_peminjaman
    public function peminjamans()
    {
        return $this->belongsToMany(Peminjaman::class, 'detil_peminjamans', 'id_buku', 'id_peminjaman');
    }

    public function detilPeminjamans()
    {
        return $this->hasMany(DetilPeminjaman::class, 'id_buku', 'id_buku');
    }
}