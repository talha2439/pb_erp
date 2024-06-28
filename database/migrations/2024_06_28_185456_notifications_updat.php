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
        Schema::table('notifications', function(Blueprint $table){
        $table->dropColumn("user_id");
        $table->dropColumn("data");
        $table->dropColumn("type");
        $table->string("route");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function(Blueprint $table){
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("data");
            $table->string("type");
            $table->dropColumn("route");
        });
    }
};
