<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans'; // PASTIKAN INI ADA
    protected $primaryKey = 'id_peminjaman';
    
    protected $fillable = [
        'kode_pinjam',
        'id_peminjam',
        'id_admin',
        'tgl_pesan',
        'tgl_ambil',
        'tgl_wajibkembali',
        'tgl_kembali',
        'status_pinjam',
    ];

    protected $casts = [
        'tgl_pesan' => 'date',
        'tgl_ambil' => 'date',
        'tgl_wajibkembali' => 'date',
        'tgl_kembali' => 'date',
    ];

    // Relasi dengan peminjam
    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'id_peminjam', 'id_peminjam');
    }

    // Relasi dengan admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    // Relasi many-to-many dengan buku melalui detil_peminjaman
    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'detil_peminjamans', 'id_peminjaman', 'id_buku');
    }

    public function detilPeminjamans()
    {
        return $this->hasMany(DetilPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    // Helper method untuk generate kode pinjam
    public static function generateKodePinjam()
    {
        do {
            $kode = 'PJM' . strtoupper(substr(uniqid(), -7));
        } while (self::where('kode_pinjam', $kode)->exists());
        
        return $kode;
    }
}