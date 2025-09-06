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
        if (!Schema::hasTable('nominations')) {
            Schema::create('nominations', function (Blueprint $table) {
                $table->id();
                
                // Category information
                $table->string('category');
                
                // Common fields that might be used across multiple categories
                $table->string('series_name')->nullable();
                $table->string('network')->nullable();
                $table->integer('year')->nullable();
                
                $table->string('actress_name')->nullable();
                $table->string('actor_name')->nullable();
                $table->string('movie')->nullable();
                $table->string('role')->nullable();
                
                $table->string('song_title')->nullable();
                $table->string('artist')->nullable();
                $table->integer('release_year')->nullable();
                
                $table->string('main_artist')->nullable();
                $table->string('featured_artists')->nullable();
                
                $table->string('stage_name')->nullable();
                $table->string('platform')->nullable();
                $table->string('profile_url')->nullable();
                
                $table->string('model_name')->nullable();
                $table->string('agency')->nullable();
                $table->string('portfolio_url')->nullable();
                
                $table->string('region')->nullable();
                $table->string('popular_song')->nullable();
                
                $table->string('domain')->nullable();
                $table->string('signature_work')->nullable();
                
                // User information (if you want to track who submitted)
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
                
                // Status of the nomination
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nominations');
    }
};