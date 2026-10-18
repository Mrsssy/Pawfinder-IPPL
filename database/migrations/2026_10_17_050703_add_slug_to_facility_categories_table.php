<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facility_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('facility_categories', 'slug')) {
                $table->string('slug', 50)->after('name')->unique();
            }
        });
    }

    public function down(): void
    {
        Schema::table('facility_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};