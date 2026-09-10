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
        Schema::table('citizens', function (Blueprint $table): void {
            $table->string('wife_name')->nullable()->after('name');
            $table->string('house_number', 50)->after('wife_name');
            $table->enum('status', ['active', 'moved', 'deceased', 'inactive'])
                ->default('active')
                ->after('financial_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table): void {
            $table->dropColumn(['wife_name', 'house_number', 'status']);
        });
    }
};
