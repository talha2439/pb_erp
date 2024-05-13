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
        Schema::table('employees' , function(Blueprint $table){
            $table->string('emergency_contact_person')->after('emergency_contact');
            $table->string('emergency_contact_relation')->after('emergency_contact_person')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees' , function(Blueprint $table){
            $table->dropColumn('emergency_contact_person');
            $table->dropColumn('emergency_contact_relation');
        });
    }
};
