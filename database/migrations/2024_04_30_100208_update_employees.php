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
        Schema::table('employees', function(Blueprint $table){
            $table->date('start_date')->nullable()->after('employment_status');
            $table->date('end_date')->nullable()->after('employment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function(Blueprint $table){
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
};
