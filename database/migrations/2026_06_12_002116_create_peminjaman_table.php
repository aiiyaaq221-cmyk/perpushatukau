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

            $table->string('kode_peminjaman')->unique();

            $table->unsignedBigInteger('id_anggota');
            $table->foreign('id_anggota')
                ->references('id_anggota')
                ->on('anggotas')
                ->cascadeOnDelete();

            $table->date('tanggal_pinjam');
            $table->date('batas_kembali');

            $table->enum('status', [
                'Dipinjam',
                'Dikembalikan',
                'Terlambat'
            ])->default('Dipinjam');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
