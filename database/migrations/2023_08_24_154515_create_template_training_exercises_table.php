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
        Schema::create('template_training_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_training_session_id')->constrained('template_training_sessions');
            $table->foreignId('exercise_id')->constrained('exercises');
            $table->float('output')->nullable();
            $table->integer('sets')->nullable();
            $table->integer('reps')->nullable();
            $table->integer('set_rest_time_seconds')->nullable();
            $table->integer('rep_rest_time_seconds')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_training_exercises');
    }
};
