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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->longText('emp_uniq_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('department');
            $table->unsignedBigInteger('designation');
            $table->unsignedBigInteger('shift')->nullable();
            $table->string('image')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('personal_email')->unique()->nullable();
            $table->string('personal_contact');
            $table->string('emergency_contact')->nullable();
            $table->longText('permanent_address');
            $table->longText('present_address')->nullable();
            $table->unsignedInteger('country')->nullable();
            $table->unsignedInteger('state')->nullable();
            $table->unsignedInteger('city')->nullable();
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('joining_date');
            $table->string('employment_status')->default('Pending');
            $table->string('cnic_number')->unique()->nullable();
            $table->string('blood_group')->nullable();
            $table->integer('martial_status')->default(0);
            $table->integer('no_of_child')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
