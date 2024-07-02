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
            $table->unsignedBigInteger('salary_id');
            $table->integer('total_leaves');
            $table->integer('total_deduction');
            $table->integer('total_off');
            $table->integer('total_absents');
            $table->integer('total_overtimes');
            $table->integer('total_overtimes_hours');
            $table->integer('total_hours_worked');
            $table->integer('over_all_salary');
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
