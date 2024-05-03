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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('check_in');
            $table->string('check_out')->nullable();
            $table->date('date');
            $table->integer('working_hours')->default(0);
            $table->integer('extra_hours')->default(0);
            $table->integer('total_hours')->default(0);
            $table->string('attendance_status')->default('absent');
            $table->string('working_status')->default('on-time');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
