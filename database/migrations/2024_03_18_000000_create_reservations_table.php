<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->integer('number_of_guests');
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->string('cancellation_reason')->nullable();
            $table->text('special_requests')->nullable();
            $table->timestamps();

            // Add unique constraint with a shorter name
            $table->unique(
                ['restaurant_id', 'table_id', 'reservation_date', 'reservation_time'],
                'reservation_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
} 