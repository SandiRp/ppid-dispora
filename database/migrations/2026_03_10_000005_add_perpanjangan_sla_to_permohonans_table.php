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
            $table->boolean('perpanjangan_sla')->default(false)->after('tanggal_respon');
            $table->text('alasan_perpanjangan')->nullable()->after('perpanjangan_sla');
            $table->timestamp('tanggal_perpanjangan')->nullable()->after('alasan_perpanjangan');
            $table->enum('tipe_permohonan', ['online', 'offline'])->default('online')->after('kategori');
            $table->string('petugas_pencatat')->nullable()->after('tipe_permohonan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn([
                'perpanjangan_sla',
                'alasan_perpanjangan',
                'tanggal_perpanjangan',
                'tipe_permohonan',
                'petugas_pencatat',
            ]);
        });
    }
};
