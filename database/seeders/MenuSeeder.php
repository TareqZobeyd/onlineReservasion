<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Restaurant;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            $cuisineType = $restaurant->cuisine_type;
            
            switch ($cuisineType) {
                case 'ایرانی':
                    $this->createIranianMenu($restaurant);
                    break;
                case 'ایتالیایی':
                    $this->createItalianMenu($restaurant);
                    break;
                case 'ژاپنی':
                    $this->createJapaneseMenu($restaurant);
                    break;
                case 'فست فود':
                    $this->createFastFoodMenu($restaurant);
                    break;
                case 'ترکی':
                    $this->createTurkishMenu($restaurant);
                    break;
                case 'چینی':
                    $this->createChineseMenu($restaurant);
                    break;
                case 'هندی':
                    $this->createIndianMenu($restaurant);
                    break;
                case 'مکزیکی':
                    $this->createMexicanMenu($restaurant);
                    break;
                case 'لبنانی':
                    $this->createLebaneseMenu($restaurant);
                    break;
                case 'فرانسوی':
                    $this->createFrenchMenu($restaurant);
                    break;
            }
        }
    }

    private function createIranianMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی ایرانی',
            'description' => 'منوی غذاهای اصیل ایرانی',
            'category' => 'ایرانی',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'چلو خورشت قیمه',
                'description' => 'برنج ایرانی با خورشت قیمه اصیل',
                'price' => 120000,
                'image_url' => 'https://example.com/ghorme-sabzi.jpg',
            ],
            [
                'name' => 'چلو جوجه کباب',
                'description' => 'برنج ایرانی با جوجه کباب تازه',
                'price' => 150000,
                'image_url' => 'https://example.com/jooje-kebab.jpg',
            ],
            [
                'name' => 'خوراک مرغ',
                'description' => 'خوراک مرغ با سبزیجات تازه',
                'price' => 100000,
                'image_url' => 'https://example.com/morgh.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }

    private function createItalianMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی ایتالیایی',
            'description' => 'منوی غذاهای ایتالیایی',
            'category' => 'ایتالیایی',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'پیتزا مارگاریتا',
                'description' => 'پیتزا با پنیر موزارلا و گوجه فرنگی',
                'price' => 180000,
                'image_url' => 'https://example.com/margherita.jpg',
            ],
            [
                'name' => 'پاستا کاربونارا',
                'description' => 'پاستا با سس خامه و بیکن',
                'price' => 160000,
                'image_url' => 'https://example.com/carbonara.jpg',
            ],
            [
                'name' => 'سالاد سزار',
                'description' => 'سالاد با مرغ گریل شده و سس سزار',
                'price' => 120000,
                'image_url' => 'https://example.com/caesar.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }

    private function createJapaneseMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی ژاپنی',
            'description' => 'منوی غذاهای ژاپنی',
            'category' => 'ژاپنی',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'سوشی سالمن',
                'description' => 'سوشی با ماهی سالمون تازه',
                'price' => 200000,
                'image_url' => 'https://example.com/salmon-sushi.jpg',
            ],
            [
                'name' => 'رامن',
                'description' => 'نودل ژاپنی با سس مخصوص',
                'price' => 150000,
                'image_url' => 'https://example.com/ramen.jpg',
            ],
            [
                'name' => 'تمپورا',
                'description' => 'سبزیجات و میگو سوخاری',
                'price' => 180000,
                'image_url' => 'https://example.com/tempura.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }

    private function createFastFoodMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی فست فود',
            'description' => 'منوی فست فود',
            'category' => 'فست فود',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'برگر دابل',
                'description' => 'برگر با دو عدد گوشت و پنیر',
                'price' => 120000,
                'image_url' => 'https://example.com/double-burger.jpg',
            ],
            [
                'name' => 'سیب زمینی سرخ کرده',
                'description' => 'سیب زمینی سرخ کرده ترد',
                'price' => 50000,
                'image_url' => 'https://example.com/fries.jpg',
            ],
            [
                'name' => 'نوگت مرغ',
                'description' => 'نوگت مرغ ترد و خوشمزه',
                'price' => 80000,
                'image_url' => 'https://example.com/nuggets.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }

    private function createTurkishMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی ترکی',
            'description' => 'منوی غذاهای ترکی',
            'category' => 'ترکی',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'کباب ترکی',
                'description' => 'کباب ترکی با برنج و سبزیجات',
                'price' => 180000,
                'image_url' => 'https://example.com/turkish-kebab.jpg',
            ],
            [
                'name' => 'پیده',
                'description' => 'پیده با گوشت چرخ کرده',
                'price' => 120000,
                'image_url' => 'https://example.com/pide.jpg',
            ],
            [
                'name' => 'باقلوا',
                'description' => 'دسر ترکی با بادام و عسل',
                'price' => 80000,
                'image_url' => 'https://example.com/baklava.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }

    private function createChineseMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی چینی',
            'description' => 'منوی غذاهای چینی',
            'category' => 'چینی',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'چیکن چائو مین',
                'description' => 'نودل با مرغ و سبزیجات',
                'price' => 150000,
                'image_url' => 'https://example.com/chow-mein.jpg',
            ],
            [
                'name' => 'سوپ وانتون',
                'description' => 'سوپ با وانتون و سبزیجات',
                'price' => 100000,
                'image_url' => 'https://example.com/wonton-soup.jpg',
            ],
            [
                'name' => 'کونگ پائو چیکن',
                'description' => 'مرغ با سس کونگ پائو',
                'price' => 160000,
                'image_url' => 'https://example.com/kung-pao.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }

    private function createIndianMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی هندی',
            'description' => 'منوی غذاهای هندی',
            'category' => 'هندی',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'بوتیر چیکن',
                'description' => 'مرغ تندوری با برنج',
                'price' => 160000,
                'image_url' => 'https://example.com/butter-chicken.jpg',
            ],
            [
                'name' => 'نان',
                'description' => 'نان تازه هندی',
                'price' => 30000,
                'image_url' => 'https://example.com/naan.jpg',
            ],
            [
                'name' => 'دال مکهانی',
                'description' => 'عدس با سس مخصوص',
                'price' => 100000,
                'image_url' => 'https://example.com/dal-makhani.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }

    private function createMexicanMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی مکزیکی',
            'description' => 'منوی غذاهای مکزیکی',
            'category' => 'مکزیکی',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'تاکو',
                'description' => 'تاکو با گوشت و سبزیجات',
                'price' => 120000,
                'image_url' => 'https://example.com/taco.jpg',
            ],
            [
                'name' => 'بوریتو',
                'description' => 'بوریتو با گوشت و لوبیا',
                'price' => 140000,
                'image_url' => 'https://example.com/burrito.jpg',
            ],
            [
                'name' => 'گواکاموله',
                'description' => 'گواکاموله تازه',
                'price' => 60000,
                'image_url' => 'https://example.com/guacamole.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }

    private function createLebaneseMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی لبنانی',
            'description' => 'منوی غذاهای لبنانی',
            'category' => 'لبنانی',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'شاورما',
                'description' => 'شاورما با مرغ یا گوشت',
                'price' => 130000,
                'image_url' => 'https://example.com/shawarma.jpg',
            ],
            [
                'name' => 'حمص',
                'description' => 'حمص با روغن زیتون',
                'price' => 70000,
                'image_url' => 'https://example.com/hummus.jpg',
            ],
            [
                'name' => 'کباب ترکی',
                'description' => 'کباب ترکی با برنج',
                'price' => 160000,
                'image_url' => 'https://example.com/kebab.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }

    private function createFrenchMenu($restaurant)
    {
        $menu = Menu::create([
            'name' => 'منوی فرانسوی',
            'description' => 'منوی غذاهای فرانسوی',
            'category' => 'فرانسوی',
            'restaurant_id' => $restaurant->id,
        ]);

        $items = [
            [
                'name' => 'کوفته گوشت',
                'description' => 'کوفته گوشت با سس قارچ',
                'price' => 180000,
                'image_url' => 'https://example.com/meatballs.jpg',
            ],
            [
                'name' => 'سوپ پیاز',
                'description' => 'سوپ پیاز فرانسوی',
                'price' => 90000,
                'image_url' => 'https://example.com/onion-soup.jpg',
            ],
            [
                'name' => 'کرپ',
                'description' => 'کرپ با شکلات و میوه',
                'price' => 100000,
                'image_url' => 'https://example.com/crepe.jpg',
            ],
        ];

        foreach ($items as $item) {
            $menu->items()->create($item);
        }
    }
} 