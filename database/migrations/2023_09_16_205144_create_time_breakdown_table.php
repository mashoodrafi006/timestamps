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
        Schema::create('time_breakdown', function (Blueprint $table) {
            $table->id();
            $table->string('first_timestamp')->nullable();
            $table->string('second_timestamp')->nullable();
            $table->json('expressions')->nullable();
            $table->json("time_breakdown")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_breakdown');
    }
};
