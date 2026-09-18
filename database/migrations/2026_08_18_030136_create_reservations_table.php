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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_code')->unique(); // Contoh: RSV-20260902-001
            $table->string('name');
            $table->string('phone');
            $table->string('table_number')->nullable();
            $table->date('reservation_date'); // Tanggal datang
            $table->time('reservation_time'); // Jam datang
            $table->integer('guest_count'); // Berapa orang
            $table->integer('total_price')->default(0); // Untuk menyimpan total bayar pre-order
            $table->text('notes')->nullable(); // Catatan khusus
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending'); // Tambah 'completed' untuk riwayat selesai
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
