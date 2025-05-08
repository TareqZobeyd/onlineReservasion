<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رستوران‌ها</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vazirmatn@33.0.3/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
        }
        .restaurant-card {
            transition: transform 0.3s ease;
        }
        .restaurant-card:hover {
            transform: translateY(-5px);
        }
        .rating-stars {
            color: #FFD700;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- هدر صفحه -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">رستوران‌های برتر</h1>
            <p class="text-gray-600">بهترین رستوران‌ها را با بهترین قیمت‌ها پیدا کنید</p>
        </div>

        <!-- فرم جستجو -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form action="{{ route('restaurants.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاریخ</label>
                    <input type="date" name="date" value="{{ request('date') }}" min="{{ date('Y-m-d') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ساعت</label>
                    <input type="time" name="time" value="{{ request('time') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تعداد نفرات</label>
                    <input type="number" name="guests" value="{{ request('guests') }}" min="1" max="20"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" 
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        جستجو
                    </button>
                </div>
            </form>
        </div>

        <!-- پیام مهمان -->
        @guest
            <div class="bg-yellow-50 border-r-4 border-yellow-400 p-4 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-yellow-400"></i>
                    </div>
                    <div class="mr-3">
                        <p class="text-sm text-yellow-700">
                            برای رزرو میز، لطفا 
                            <a href="{{ route('login') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600">وارد شوید</a>
                            یا
                            <a href="{{ route('register') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600">ثبت نام کنید</a>
                        </p>
                    </div>
                </div>
            </div>
        @endguest

        <!-- لیست رستوران‌ها -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($restaurants as $restaurant)
                <div class="restaurant-card bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="relative">
                        <img src="{{ $restaurant->image_url }}" alt="{{ $restaurant->name }}" 
                            class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full shadow-md">
                            <div class="flex items-center">
                                <i class="fas fa-star rating-stars ml-1"></i>
                                <span class="text-gray-800 font-semibold">{{ number_format($restaurant->average_rating, 1) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $restaurant->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($restaurant->description, 100) }}</p>
                        <div class="flex items-center text-gray-500 mb-4">
                            <i class="fas fa-utensils ml-2"></i>
                            <span>{{ $restaurant->cuisine_type }}</span>
                        </div>
                        <div class="flex items-center text-gray-500 mb-4">
                            <i class="fas fa-map-marker-alt ml-2"></i>
                            <span>{{ Str::limit($restaurant->address, 50) }}</span>
                        </div>
                        <a href="{{ route('restaurants.show', $restaurant) }}" 
                            class="block w-full text-center bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            {{ auth()->check() ? 'رزرو میز' : 'مشاهده و رزرو' }}
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-500">
                        <i class="fas fa-search text-4xl mb-4"></i>
                        <p class="text-xl">هیچ رستورانی یافت نشد</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- صفحه‌بندی -->
        <div class="mt-8">
            {{ $restaurants->links() }}
        </div>
    </div>
</body>
</html> 