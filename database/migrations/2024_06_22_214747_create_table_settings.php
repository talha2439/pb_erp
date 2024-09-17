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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('site_url');
            $table->longText('favicon');
            $table->longText('logo');
            $table->longText('light_logo')->nullable();
            $table->string('meta_title');
            $table->longText('meta_description');
            $table->longText('meta_keywords')->nullable();
            $table->string('timezone')->default('Asia/karachi');
            $table->integer('email_send')->default(0);
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
