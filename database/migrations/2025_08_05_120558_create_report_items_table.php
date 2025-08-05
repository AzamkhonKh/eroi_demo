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
        Schema::create('report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('expense_reports')->cascadeOnDelete();
            $table->foreignId('traffic_source_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_amount', 10, 2); // Sum of expenses for this source
            $table->decimal('percentage', 5, 2); // Percentage of total expenses
            $table->integer('expense_count'); // Number of expense records
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_items');
    }
};
