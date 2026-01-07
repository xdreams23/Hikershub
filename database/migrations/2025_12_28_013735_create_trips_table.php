<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mountain_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration_days');
            $table->string('meeting_point');
            $table->decimal('price', 10, 2);
            $table->integer('max_participants');
            $table->integer('min_participants')->default(1);
            $table->enum('status', ['open', 'full', 'closed', 'cancelled'])->default('open');
            $table->text('itinerary')->nullable();
            $table->text('include_items')->nullable();
            $table->text('exclude_items')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('start_date');
            $table->index(['mountain_id', 'start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};