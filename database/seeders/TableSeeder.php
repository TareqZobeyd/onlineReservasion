<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;
use App\Models\Restaurant;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            // ایجاد میزهای 2 نفره
            for ($i = 1; $i <= 5; $i++) {
                Table::create([
                    'restaurant_id' => $restaurant->id,
                    'table_number' => $i,
                    'capacity' => 2,
                    'is_available' => true,
                ]);
            }

            // ایجاد میزهای 4 نفره
            for ($i = 6; $i <= 10; $i++) {
                Table::create([
                    'restaurant_id' => $restaurant->id,
                    'table_number' => $i,
                    'capacity' => 4,
                    'is_available' => true,
                ]);
            }

            // ایجاد میزهای 6 نفره
            for ($i = 11; $i <= 13; $i++) {
                Table::create([
                    'restaurant_id' => $restaurant->id,
                    'table_number' => $i,
                    'capacity' => 6,
                    'is_available' => true,
                ]);
            }

            // ایجاد میزهای 8 نفره
            for ($i = 14; $i <= 15; $i++) {
                Table::create([
                    'restaurant_id' => $restaurant->id,
                    'table_number' => $i,
                    'capacity' => 8,
                    'is_available' => true,
                ]);
            }
        }
    }
} 