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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['akses', 'pelayanan']); // Pembeda jenis laporan
            $table->string('tahun', 4);
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_pdf'); // Lokasi file PDF laporan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
