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
        Schema::create('reservation_details', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel reservations
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            // Relasi ke tabel menus
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->integer('qty'); // Jumlah porsi yang dipesan
            $table->integer('price'); // Harga satuan menu saat dipesan
            $table->integer('subtotal'); // qty x price
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_details');
    }
};
