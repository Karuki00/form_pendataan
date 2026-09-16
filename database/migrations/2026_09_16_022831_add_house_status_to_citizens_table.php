<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citizens', function (Blueprint $table): void {
            $table->string('house_status', 20)->default('owned')->after('monthly_income');
        });

        DB::table('citizens')->where('status', 'middle_income')->update(['house_status' => 'rented']);
        DB::table('citizens')->where('status', 'high_income')->update(['house_status' => 'owned']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table): void {
            $table->dropColumn('house_status');
        });
    }
};
