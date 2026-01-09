<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;
    
    public function up(): void
    {
        Schema::create('mountains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->integer('altitude'); // dalam meter
            $table->enum('difficulty_level', ['easy', 'medium', 'hard', 'extreme']);
            $table->text('description');
            $table->string('image')->nullable();
            $table->text('facilities')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('difficulty_level');
            $table->index('location');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mountains');
    }
};