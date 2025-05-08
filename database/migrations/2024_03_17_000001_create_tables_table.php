<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('table_number');
            $table->integer('capacity');
            $table->string('location')->nullable(); // e.g., indoor, outdoor, bar
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            // Ensure table numbers are unique within each restaurant
            $table->unique(['restaurant_id', 'table_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
} 