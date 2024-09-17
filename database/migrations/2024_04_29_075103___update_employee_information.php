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
       Schema::table('employees',function(Blueprint $table){
        $table->string('cv_file')->after('image')->nullable();
        $table->string('gender')->after('date_of_birth');
        $table->string('salary')->default(0);
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('employees',function(Blueprint $table){
        $table->dropColumn('cv_file');
        $table->dropColumn('salary');
        $table->dropColumn('gender');


       });
    }
};
