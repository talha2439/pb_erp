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
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('working_hours')->change()->nullable();
            $table->string('extra_hours')->change()->nullable();
            $table->string('total_hours')->change()->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->integer('working_hours')->change()->nullable();
            $table->integer('extra_hours')->change()->nullable();
            $table->integer('total_hours')->change()->nullable();

        });
    }
};
