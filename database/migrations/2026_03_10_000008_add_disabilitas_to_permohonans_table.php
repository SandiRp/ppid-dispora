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
            $table->boolean('is_disabilitas')->default(false)->after('petugas_pencatat');
            $table->string('ragam_disabilitas')->nullable()->after('is_disabilitas');
            $table->string('format_jawaban_khusus')->nullable()->after('ragam_disabilitas');
            $table->text('kebutuhan_khusus')->nullable()->after('format_jawaban_khusus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn([
                'is_disabilitas',
                'ragam_disabilitas',
                'format_jawaban_khusus',
                'kebutuhan_khusus'
            ]);
        });
    }
};
