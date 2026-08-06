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
        Schema::table('bukus', function (Blueprint $table) {
            $table->string('isbn', 20) ->nullable() ->after('kode_buku');
            $table->text('deskripsi') ->nullable() ->after('cover');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {

            $table->dropColumn('isbn');
            $table->dropColumn('deskripsi');

        });
    }
};