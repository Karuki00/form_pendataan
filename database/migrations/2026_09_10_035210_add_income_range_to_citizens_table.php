<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('citizens', function (Blueprint $table): void {
            $table->string('income_range', 20)->default('0_3jt')->after('monthly_income');
        });

        DB::table('citizens')->where('financial_status', 'middle_income')->update(['income_range' => '4_8jt']);
        DB::table('citizens')->where('financial_status', 'high_income')->update(['income_range' => 'above_15jt']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table): void {
            $table->dropColumn('income_range');
        });
    }
};
