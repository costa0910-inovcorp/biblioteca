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
        Schema::create('book_wait_list', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('position');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignUuid('book_id')->constrained('books', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_wait_list');
    }
};
