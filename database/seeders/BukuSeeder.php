<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $bukus = [
            [
                'judul_buku' => 'Laskar Pelangi',
                'tgl_terbit' => '2005-09-01',
                'nama_pengarang' => 'Andrea Hirata',
                'nama_penerbit' => 'Bentang Pustaka'
            ],
            [
                'judul_buku' => 'Bumi Manusia',
                'tgl_terbit' => '1980-05-15',
                'nama_pengarang' => 'Pramoedya Ananta Toer',
                'nama_penerbit' => 'Hasta Mitra'
            ],
            [
                'judul_buku' => 'Perahu Kertas',
                'tgl_terbit' => '2009-07-20',
                'nama_pengarang' => 'Dee Lestari',
                'nama_penerbit' => 'Bentang Pustaka'
            ],
            [
                'judul_buku' => 'Negeri 5 Menara',
                'tgl_terbit' => '2009-02-10',
                'nama_pengarang' => 'Ahmad Fuadi',
                'nama_penerbit' => 'Gramedia Pustaka Utama'
            ],
            [
                'judul_buku' => 'Sang Pemimpi',
                'tgl_terbit' => '2006-11-15',
                'nama_pengarang' => 'Andrea Hirata',
                'nama_penerbit' => 'Bentang Pustaka'
            ],
            [
                'judul_buku' => 'Ayat-Ayat Cinta',
                'tgl_terbit' => '2004-12-01',
                'nama_pengarang' => 'Habiburrahman El Shirazy',
                'nama_penerbit' => 'Republika'
            ],
            [
                'judul_buku' => 'Dilan: Dia adalah Dilanku Tahun 1990',
                'tgl_terbit' => '2014-05-01',
                'nama_pengarang' => 'Pidi Baiq',
                'nama_penerbit' => 'Pastel Books'
            ],
            [
                'judul_buku' => 'Hujan',
                'tgl_terbit' => '2016-01-20',
                'nama_pengarang' => 'Tere Liye',
                'nama_penerbit' => 'Gramedia Pustaka Utama'
            ],
            [
                'judul_buku' => 'Pulang',
                'tgl_terbit' => '2012-08-15',
                'nama_pengarang' => 'Tere Liye',
                'nama_penerbit' => 'Republika'
            ],
            [
                'judul_buku' => 'Ronggeng Dukuh Paruk',
                'tgl_terbit' => '1982-03-10',
                'nama_pengarang' => 'Ahmad Tohari',
                'nama_penerbit' => 'Gramedia'
            ],
        ];

        foreach ($bukus as $buku) {
            DB::table('bukus')->insert(array_merge($buku, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}