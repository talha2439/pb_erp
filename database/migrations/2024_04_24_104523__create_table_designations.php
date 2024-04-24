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
       Schema::create('designations' , function (Blueprint $blueprint) {
        $blueprint->id();
        $blueprint->unsignedBigInteger('department');
        $blueprint->string('name');
        $blueprint->softDeletes();
        $blueprint->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
