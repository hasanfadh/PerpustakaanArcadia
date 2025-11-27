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
        Schema::create('peminjams', function (Blueprint $table) {
            $table->id('id_peminjam');
            $table->string('nama_peminjam', 150);
            $table->date('tgl_daftar');
            $table->string('user_peminjam', 50);
            $table->string('pass_peminjam', 255);
            $table->string('foto_peminjam', 255)->nullable();
            $table->boolean('status_peminjam')->default(true); // true = aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjams');
    }
};
