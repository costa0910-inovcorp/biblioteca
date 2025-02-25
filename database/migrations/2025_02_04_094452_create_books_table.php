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
            $table->text('isbn')->nullable();
            $table->timestamps();
            $table->text('name');
            $table->text('bibliography')->nullable();
            $table->text('cover_image')->nullable();
            $table->decimal('price');
            $table->string('stripe_price_id')->nullable()->default(null);
            $table->boolean('is_available')->default(true);
            $table->foreignUuid('publisher_id')->nullable()
                ->constrained('publishers', 'id')->nullOnDelete();
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
