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
        Schema::create('informasis', function (Blueprint $table) {
            $table->id();
            $table->string('ringkasan_informasi'); // Judul Informasi
            $table->text('deskripsi')->nullable(); // Penjelasan singkat
            $table->string('penanggung_jawab'); // Bidang/Sekretariat yang bertanggung jawab
            $table->string('tahun', 4);
            $table->string('format')->default('PDF'); // Format file (PDF, XLSX, DOCX)
            $table->string('file_dokumen')->nullable(); // Lokasi file yang diupload (bisa null untuk Dikecualikan)
            $table->enum('kategori', ['berkala', 'serta_merta', 'setiap_saat', 'dikecualikan']); // Pembagi halaman
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasis');
    }
};
