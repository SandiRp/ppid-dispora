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
        Schema::create('surveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->nullable()->constrained('permohonans')->onDelete('set null');
            $table->string('nama_responden')->nullable();
            $table->string('email_responden')->nullable();

            // 9 Indikator Kepuasan Permenpan RB No. 14 Tahun 2017 (skor 1-4)
            $table->unsignedTinyInteger('kesesuaian_persyaratan'); // U1
            $table->unsignedTinyInteger('kemudahan_prosedur');      // U2
            $table->unsignedTinyInteger('kecepatan_waktu');         // U3
            $table->unsignedTinyInteger('kewajaran_biaya');         // U4
            $table->unsignedTinyInteger('kesesuaian_produk');       // U5
            $table->unsignedTinyInteger('kompetensi_petugas');      // U6
            $table->unsignedTinyInteger('kesopanan_petugas');       // U7
            $table->unsignedTinyInteger('kualitas_sarana');         // U8
            $table->unsignedTinyInteger('penanganan_pengaduan');    // U9

            $table->decimal('skor_rata_rata', 4, 2); // Skor total (1.00 - 4.00)
            $table->decimal('nilai_ikm', 5, 2);       // Konversi IKM (25 - 100)
            $table->text('saran_masukan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveis');
    }
};
