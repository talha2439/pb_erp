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
        Schema::create('employee_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('institute');
            $table->string('qualification');
            $table->string('document')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->default(0); //1=> ended , 0 => continued
            $table->integer('gpa')->default(0);
            $table->integer('percentage')->default(0);
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_qualifications');
    }
};
