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
        Schema::table('time_breakdown', function (Blueprint $table) {
            $table->unique(['first_timestamp', 'second_timestamp', 'expressions'], 'unique_time_breakdown');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_breakdown', function (Blueprint $table) {
            $table->dropUnique('unique_time_breakdown');
        });
    }
};
