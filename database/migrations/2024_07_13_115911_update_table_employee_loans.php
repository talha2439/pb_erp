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
        Schema::table('employee_loans', function(Blueprint $table){
            $table->string('repay_type')->default('monthly')->after('due_date');
            $table->integer('total_month')->default(0)->after('repay_type');
            $table->integer('partial_amount')->default(0)->after('total_month');
            $table->date('request_date')->nullable()->change();
            $table->date('due_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_loans', function(Blueprint $table){
            $table->dropColumn('repay_type');
            $table->dropColumn('total_month');
            $table->dropColumn('partial_amount');
            $table->string('request_date')->change();
            $table->string('due_date')->change();
        });
    }
};
