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
        Schema::create('pengunjungs', function (Blueprint $table) {

            $table->id('id_tamu');
            $table->foreignId('id_anggota')->nullable()
                ->constrained('anggotas', 'id_anggota')
                ->nullOnDelete();
            $table->enum('jenis_pengunjung', ['anggota', 'non_anggota']);
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->integer('umur')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('status_pengunjung')->nullable();
            $table->string('tujuan');
            $table->text('keterangan')->nullable();
            $table->dateTime('tanggal_kunjungan');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengunjungs');
    }
};
