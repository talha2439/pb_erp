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
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('applied_by');
            $table->string('leave_type');
            $table->date('from_date');
            $table->date('to_date');
            $table->longText('reason');
            $table->longText('remarks')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->default('pending');
            $table->integer('total_days')->default(0);
            $table->integer('approved_days')->default(0);
            $table->integer('rejected_days')->default(0);
            $table->text('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_applications');
    }
};
