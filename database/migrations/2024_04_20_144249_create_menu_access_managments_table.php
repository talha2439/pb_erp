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
        Schema::create('menu_access_managments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_menu_id');
            $table->integer('has_all')->default(0);
            $table->integer('view_status')->default(0);
            $table->integer('create_status')->default(0);
            $table->integer('update_status')->default(0);
            $table->integer('delete_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_access_managments');
    }
};
