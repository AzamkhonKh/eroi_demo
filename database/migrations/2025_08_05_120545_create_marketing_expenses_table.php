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
        Schema::create('marketing_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('traffic_source_id')->constrained()->restrictOnDelete();
            $table->decimal('amount', 10, 2); // Expense amount (10,2 precision)
            $table->date('expense_date'); // Date of the expense
            $table->text('notes')->nullable(); // Optional notes about the expense
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Indexes for performance
            $table->index(['expense_date', 'traffic_source_id']);
            $table->index('expense_date');
            $table->index('traffic_source_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_expenses');
    }
};
