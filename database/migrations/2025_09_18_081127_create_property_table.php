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
        Schema::create('property', function (Blueprint $table) {
            $table->id();
            $table->string('address')->unique();
            $table->double('price');
            $table->string('city');
            $table->string('status');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->unsignedSmallInteger('bathrooms')->nullable();
            $table->boolean('balcony')->nullable();
            $table->boolean('garden')->nullable();
            $table->timestamps();

            // Handige indexen voor filters
            $table->index('city');
            $table->index('price');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property');
    }
};
