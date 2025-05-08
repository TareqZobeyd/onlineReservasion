<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = [
            [
                'name' => 'رستوران ایرانی شاندیز',
                'description' => 'رستوران سنتی ایرانی با منوی متنوع از غذاهای اصیل ایرانی',
                'address' => 'تهران، خیابان ولیعصر، خیابان فرشته',
                'phone_number' => '021-12345678',
                'cuisine_type' => 'ایرانی',
                'price_range' => 'متوسط',
                'opening_time' => '11:00:00',
                'closing_time' => '23:00:00',
                'average_rating' => 4.5,
                'has_outdoor' => true,
                'has_private' => true,
                'has_parking' => true,
                'image_url' => 'restaurants/shandiz.jpg'
            ],
            [
                'name' => 'رستوران ایتالیایی میلانو',
                'description' => 'رستوران ایتالیایی با منوی متنوع از پاستا و پیتزا',
                'address' => 'تهران، خیابان شریعتی، خیابان قبا',
                'phone_number' => '021-87654321',
                'cuisine_type' => 'ایتالیایی',
                'price_range' => 'بالا',
                'opening_time' => '12:00:00',
                'closing_time' => '00:00:00',
                'average_rating' => 4.3,
                'has_outdoor' => true,
                'has_private' => true,
                'has_parking' => true,
                'image_url' => 'restaurants/milano.jpg'
            ],
            [
                'name' => 'رستوران ژاپنی سوشی بار',
                'description' => 'رستوران ژاپنی با منوی متنوع از سوشی و غذاهای آسیایی',
                'address' => 'تهران، خیابان پاسداران، خیابان گلستان',
                'phone_number' => '021-23456789',
                'cuisine_type' => 'ژاپنی',
                'price_range' => 'بالا',
                'opening_time' => '12:00:00',
                'closing_time' => '23:00:00',
                'average_rating' => 4.7,
                'has_outdoor' => false,
                'has_private' => true,
                'has_parking' => true,
                'image_url' => 'restaurants/sushi.jpg'
            ],
            [
                'name' => 'رستوران فست فود برگر کینگ',
                'description' => 'رستوران فست فود با منوی متنوع از همبرگر و ساندویچ',
                'address' => 'تهران، خیابان ولیعصر، خیابان فرشته',
                'phone_number' => '021-34567890',
                'cuisine_type' => 'فست فود',
                'price_range' => 'متوسط',
                'opening_time' => '10:00:00',
                'closing_time' => '22:00:00',
                'average_rating' => 4.0,
                'has_outdoor' => true,
                'has_private' => false,
                'has_parking' => true,
                'image_url' => 'restaurants/burger.jpg'
            ],
            [
                'name' => 'رستوران ترکی سلطان',
                'description' => 'رستوران ترکی با منوی متنوع از کباب و غذاهای ترکی',
                'address' => 'تهران، خیابان شریعتی، خیابان قبا',
                'phone_number' => '021-45678901',
                'cuisine_type' => 'ترکی',
                'price_range' => 'متوسط',
                'opening_time' => '11:00:00',
                'closing_time' => '23:00:00',
                'average_rating' => 4.2,
                'has_outdoor' => true,
                'has_private' => true,
                'has_parking' => true,
                'image_url' => 'restaurants/sultan.jpg'
            ],
            [
                'name' => 'رستوران چینی دراگون',
                'description' => 'رستوران چینی با منوی متنوع از غذاهای آسیایی',
                'address' => 'تهران، خیابان پاسداران، خیابان گلستان',
                'phone_number' => '021-56789012',
                'cuisine_type' => 'چینی',
                'price_range' => 'بالا',
                'opening_time' => '12:00:00',
                'closing_time' => '23:00:00',
                'average_rating' => 4.4,
                'has_outdoor' => false,
                'has_private' => true,
                'has_parking' => true,
                'image_url' => 'restaurants/dragon.jpg'
            ],
            [
                'name' => 'رستوران هندی تاج محل',
                'description' => 'رستوران هندی با منوی متنوع از غذاهای هندی',
                'address' => 'تهران، خیابان ولیعصر، خیابان فرشته',
                'phone_number' => '021-67890123',
                'cuisine_type' => 'هندی',
                'price_range' => 'متوسط',
                'opening_time' => '11:00:00',
                'closing_time' => '23:00:00',
                'average_rating' => 4.1,
                'has_outdoor' => true,
                'has_private' => true,
                'has_parking' => true,
                'image_url' => 'restaurants/taj.jpg'
            ],
            [
                'name' => 'رستوران مکزیکی ال پاتریو',
                'description' => 'رستوران مکزیکی با منوی متنوع از غذاهای مکزیکی',
                'address' => 'تهران، خیابان شریعتی، خیابان قبا',
                'phone_number' => '021-78901234',
                'cuisine_type' => 'مکزیکی',
                'price_range' => 'متوسط',
                'opening_time' => '12:00:00',
                'closing_time' => '23:00:00',
                'average_rating' => 4.3,
                'has_outdoor' => true,
                'has_private' => true,
                'has_parking' => true,
                'image_url' => 'restaurants/patrio.jpg'
            ],
            [
                'name' => 'رستوران لبنانی بیتوت',
                'description' => 'رستوران لبنانی با منوی متنوع از غذاهای لبنانی',
                'address' => 'تهران، خیابان پاسداران، خیابان گلستان',
                'phone_number' => '021-89012345',
                'cuisine_type' => 'لبنانی',
                'price_range' => 'بالا',
                'opening_time' => '11:00:00',
                'closing_time' => '23:00:00',
                'average_rating' => 4.6,
                'has_outdoor' => true,
                'has_private' => true,
                'has_parking' => true,
                'image_url' => 'restaurants/baytut.jpg'
            ],
            [
                'name' => 'رستوران فرانسوی لوف',
                'description' => 'رستوران فرانسوی با منوی متنوع از غذاهای فرانسوی',
                'address' => 'تهران، خیابان ولیعصر، خیابان فرشته',
                'phone_number' => '021-90123456',
                'cuisine_type' => 'فرانسوی',
                'price_range' => 'بالا',
                'opening_time' => '12:00:00',
                'closing_time' => '00:00:00',
                'average_rating' => 4.8,
                'has_outdoor' => true,
                'has_private' => true,
                'has_parking' => true,
                'image_url' => 'restaurants/louvre.jpg'
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
} 