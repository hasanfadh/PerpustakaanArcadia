<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Peminjam extends Authenticatable
{
    protected $table = 'peminjams';
    protected $primaryKey = 'id_peminjam';
    
    protected $fillable = [
        'nama_peminjam',
        'tgl_daftar',
        'user_peminjam',
        'pass_peminjam',
        'foto_peminjam',
        'status_peminjam',
    ];

    protected $hidden = [
        'pass_peminjam',
    ];

    protected $casts = [
        'tgl_daftar' => 'date',
        'status_peminjam' => 'boolean',
    ];

    // Override method untuk authentication
    public function getAuthPassword()
    {
        return $this->pass_peminjam;
    }

    // Relasi dengan peminjaman 
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_peminjam', 'id_peminjam');
    }
}