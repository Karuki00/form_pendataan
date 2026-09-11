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
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('name');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->integer('children_count')->default(0);
            $table->decimal('monthly_income', 12, 2)->default(0.00);
            $table->enum('financial_status', ['low_income', 'middle_income', 'high_income']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
