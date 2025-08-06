<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration  {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('street');
            $table->string('number');
            $table->string('complement')->nullable();
            $table->string('district');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code', 10);
            $table->string('country')->default('Brasil');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('addresses');
    }
};
