<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->json('working_hours')->comment('Working hours for each day of the week');
            $table->json('holidays')->nullable()->comment('List of holiday dates');
            $table->integer('min_reservation_notice')->default(60)->comment('Minimum notice time in minutes');
            $table->integer('max_reservation_notice')->default(43200)->comment('Maximum notice time in minutes (30 days)');
            $table->integer('max_guests_per_reservation')->default(20);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_settings');
    }
}; 