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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->string('kode_pinjam', 10)->unique();
            $table->foreignId('id_peminjam')->constrained('peminjams', 'id_peminjam')->onDelete('cascade');
            $table->foreignId('id_admin')->nullable()->constrained('admins', 'id_admin')->onDelete('set null');
            $table->date('tgl_pesan');
            $table->date('tgl_ambil')->nullable();
            $table->date('tgl_wajibkembali')->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->string('status_pinjam', 10)->default('DIPROSES'); // DIPROSES, DISETUJUI, DITOLAK, SELESAI
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
