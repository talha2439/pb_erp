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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->longText('document');
            $table->timestamps();
        });
        Schema::table('employees' , function(Blueprint $table) {
            $table->dropColumn('cv_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
        Schema::table('employees' , function(Blueprint $table) {
            $table->longText('cv_file')->after('image');
        });
    }
};
