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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id('id_buku');
            $table->unsignedBigInteger('id_kategori');
            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategoris')
                ->cascadeOnDelete();
            $table->string('kode_buku')->unique();
            $table->string('judul_buku');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->date('tanggal_masuk');
            $table->string('jilid')->nullable();
            $table->string('edisi')->nullable();
            $table->string('sumber')->nullable();
            $table->integer('eksemplar')->default(1);
            $table->integer('jumlah_buku')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->string('cover')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
