<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facility_categories', function (Blueprint $table) {
            // Memastikan kolom name ditambahkan jika belum ada
            if (!Schema::hasColumn('facility_categories', 'name')) {
                $table->string('name', 50)->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('facility_categories', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};