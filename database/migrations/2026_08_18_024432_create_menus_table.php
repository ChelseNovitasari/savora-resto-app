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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            // Menghubungkan/relasi menu ke kategori
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique(); // Ditambahkan untuk SEO / URL rapi
            $table->text('description')->nullable();
            $table->integer('price'); // Harga makanan/minuman
            $table->string('image')->nullable(); // Foto makanan
            $table->boolean('is_available')->default(true); // Status: Ready/Habis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
