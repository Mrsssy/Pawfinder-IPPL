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
    Schema::create('facilities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('facility_categories')->onDelete('cascade');
        $table->string('name', 150);
        $table->string('address', 255);
        $table->decimal('latitude', 10, 7);
        $table->decimal('longitude', 10, 7);
        $table->string('opening_hours', 255)->nullable();
        $table->string('phone', 30)->nullable();
        $table->text('description')->nullable();
        $table->text('services')->nullable();
        $table->decimal('rating', 2, 1)->nullable();
        $table->string('photo_url', 255)->nullable();
        $table->timestamps();

        // Indeks untuk performa pencarian dan spasial
        $table->index('category_id');
        $table->index(['latitude', 'longitude']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
