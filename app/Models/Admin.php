<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    
    protected $fillable = [
        'nama_admin',
        'user_admin',
        'pass_admin',
    ];

    protected $hidden = [
        'pass_admin',
    ];

    // Override method untuk authentication
    public function getAuthPassword()
    {
        return $this->pass_admin;
    }

    // Relasi dengan peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_admin', 'id_admin');
    }
}