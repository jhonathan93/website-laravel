<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration  {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('category_movie', function (Blueprint $table) {
            $table->uuid()->unique();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->primary(['movie_id', 'category_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('category_movie');
    }
};
