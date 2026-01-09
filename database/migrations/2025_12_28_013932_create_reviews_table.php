<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;
    
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('rating'); // 1-5
            $table->text('comment');
            $table->timestamps();
            
            // Indexes
            $table->index('rating');
            $table->unique(['trip_id', 'user_id']); // User hanya bisa review 1x per trip
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};