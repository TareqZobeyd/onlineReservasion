<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('phone_number');
            $table->string('cuisine_type');
            $table->string('price_range');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->boolean('has_outdoor')->default(false);
            $table->boolean('has_private')->default(false);
            $table->boolean('has_parking')->default(false);
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
}
