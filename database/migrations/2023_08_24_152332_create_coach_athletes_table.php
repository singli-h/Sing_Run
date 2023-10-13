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
        Schema::create('coach_athletes', function (Blueprint $table) {
            $table->foreignId('coach_id')->constrained('coaches');
            $table->foreignId('athlete_id')->constrained('athletes');
            $table->primary(['coach_id', 'athlete_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_athletes');
    }
};
