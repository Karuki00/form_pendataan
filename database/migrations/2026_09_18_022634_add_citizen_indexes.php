<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->index('name');
            $table->index('house_number');
            $table->index('status');
            $table->index('marital_status');
            $table->index('income_range');
            $table->index('house_status');
        });
    }

    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['house_number']);
            $table->dropIndex(['status']);
            $table->dropIndex(['marital_status']);
            $table->dropIndex(['income_range']);
            $table->dropIndex(['house_status']);
        });
    }
};
