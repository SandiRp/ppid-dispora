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
        Schema::table('permohonans', function (Blueprint $table) {
            $table->text('alasan_penolakan')->nullable()->after('catatan_admin');
            $table->string('file_jawaban')->nullable()->after('alasan_penolakan');
            $table->timestamp('tanggal_respon')->nullable()->after('file_jawaban');
        });

        Schema::create('keberatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');
            $table->string('nomor_keberatan', 50)->unique();
            $table->string('nama_pemohon');
            $table->string('email');
            $table->string('nomor_telepon', 30)->nullable();
            $table->string('alasan_keberatan'); // misal: Penolakan atas permohonan, informasi tidak disediakan, dll
            $table->text('keterangan_keberatan');
            $table->string('file_pendukung')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('tanggapan_atasan_ppid')->nullable();
            $table->timestamp('tanggal_tanggapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keberatans');

        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['alasan_penolakan', 'file_jawaban', 'tanggal_respon']);
        });
    }
};
