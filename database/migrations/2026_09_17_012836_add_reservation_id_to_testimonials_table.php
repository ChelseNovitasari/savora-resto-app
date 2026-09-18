<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Menghubungkan testimoni ke tabel reservations
            $table->foreignId('reservation_id')->nullable()->after('id')->constrained('reservations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['reservation_id']);
            $table->dropColumn(['reservation_id']);
        });
    }
};
