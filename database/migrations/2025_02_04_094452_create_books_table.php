<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{/**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('isbn');
            $table->timestamps();
            $table->string('name');
            $table->text('bibliography');
            $table->text('cover_image');
            $table->decimal('price');
            $table->boolean('is_available')->default(true);
            $table->foreignUuid('publisher_id')->constrained('publishers', 'id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
