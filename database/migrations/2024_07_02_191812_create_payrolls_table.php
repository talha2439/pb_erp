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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number');
            $table->unsignedBigInteger('employee_id');
            $table->integer('gross_salary');
            $table->integer('loan_amount')->default(0);
            $table->integer('bonus_amount')->default(0);
            $table->integer('total_leaves')->default(0);
            $table->integer('total_lates')->default(0);
            $table->integer('total_early_outs')->default(0);
            $table->integer('total_deduction')->default(0);
            $table->integer('total_off')->default(0);
            $table->integer('per_absents_deduction')->default(0);
            $table->integer('total_absents')->default(0);
            $table->string('total_hours_worked')->default(0);
            $table->integer('over_all_salary')->default(0);
            $table->string('date');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
