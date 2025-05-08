<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('صفحه اصلی') }}
            </h2>
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-800 hover:bg-purple-700">
                        <i class="fas fa-tachometer-alt ml-2"></i>
                        پنل مدیریت
                    </a>
                @elseif(auth()->user()->hasRole('restaurant_owner'))
                    <a href="{{ route('restaurant.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-500">
                        <i class="fas fa-store ml-2"></i>
                        داشبورد رستوران
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500">
                        <i class="fas fa-user ml-2"></i>
                        پروفایل من
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <!-- Hero Section with Search -->
    <div class="relative bg-gradient-to-br from-purple-600 via-pink-500 to-red-500">
        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-16 md:py-24">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-pink-300 via-purple-300 to-blue-300 sm:text-5xl md:text-6xl">
                        <span class="block">رزرو آنلاین رستوران</span>
                        <span class="block text-yellow-300 mt-2">سریع، آسان و مطمئن</span>
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-xl text-pink-200">
                        در کمتر از یک دقیقه میز رستوران مورد نظر خود را رزرو کنید
                    </p>
                </div>

                <!-- Search Box -->
                <div class="mt-12 max-w-xl mx-auto">
                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl p-6 border-2 border-pink-200">
                        <form action="{{ route('restaurants.index') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-purple-700">تاریخ رزرو</label>
                                    <input type="date" name="date" id="date" 
                                           class="mt-1 block w-full rounded-lg border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                                           min="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label for="time" class="block text-sm font-medium text-purple-700">ساعت رزرو</label>
                                    <select name="time" id="time" 
                                            class="mt-1 block w-full rounded-lg border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                        <option value="">ساعت را انتخاب کنید</option>
                                        @for($hour = 12; $hour <= 23; $hour++)
                                            @for($minute = 0; $minute < 60; $minute += 30)
                                                <option value="{{ sprintf('%02d:%02d', $hour, $minute) }}">
                                                    {{ sprintf('%02d:%02d', $hour, $minute) }}
                                                </option>
                                            @endfor
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="guests" class="block text-sm font-medium text-purple-700">تعداد نفرات</label>
                                <select name="guests" id="guests" 
                                        class="mt-1 block w-full rounded-lg border-pink-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                                    <option value="">تعداد نفرات را انتخاب کنید</option>
                                    @for($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}">{{ $i }} نفر</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200">
                                جستجوی رستوران
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Restaurants Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">
                رستوران‌های محبوب
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($popularRestaurants as $restaurant)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
                    <img src="{{ $restaurant->image_url }}" alt="{{ $restaurant->name }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-900">{{ $restaurant->name }}</h3>
                            <div class="flex items-center">
                                <span class="text-yellow-400">
                                    <i class="fas fa-star"></i>
                                </span>
                                <span class="ml-1 text-gray-600">{{ number_format($restaurant->average_rating, 1) }}</span>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">{{ Str::limit($restaurant->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">{{ $restaurant->cuisine_type }}</span>
                            <a href="{{ route('restaurants.show', $restaurant) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                                مشاهده و رزرو
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-gradient-to-br from-purple-50 to-pink-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    چرا رزرو آنلاین؟
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    مزایای استفاده از سیستم رزرو آنلاین رستوران
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">رزرو سریع</h3>
                    <p class="text-gray-600">در کمتر از یک دقیقه میز رستوران مورد نظر خود را رزرو کنید</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">تنوع رستوران</h3>
                    <p class="text-gray-600">دسترسی به بهترین رستوران‌های شهر با منوهای متنوع</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="text-purple-600 text-4xl mb-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">پرداخت امن</h3>
                    <p class="text-gray-600">پرداخت آنلاین با درگاه‌های معتبر بانکی</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">آماده رزرو میز هستید؟</span>
                <span class="block text-pink-200">همین حالا شروع کنید</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('restaurants.index') }}" 
                       class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-purple-600 bg-white hover:bg-pink-50">
                        مشاهده رستوران‌ها
                    </a>
                </div>
                @if(auth()->check() && auth()->user()->hasRole('admin'))
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-purple-800 hover:bg-purple-700">
                        پنل مدیریت
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/persian-datepicker@latest/dist/js/persian-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@latest/dist/css/persian-datepicker.min.css">
    <script>
        $(document).ready(function() {
            console.log('jQuery is loaded');
            
            // اطمینان از لود شدن persianDatepicker
            if (typeof $.fn.persianDatepicker === 'undefined') {
                console.error('persianDatepicker is not loaded');
                return;
            }

            // تنظیمات تاریخ‌شمار
            var datepickerOptions = {
                format: 'YYYY/MM/DD',
                initialValue: false,
                autoClose: true,
                onSelect: function(unix) {
                    console.log('Date selected:', unix);
                    
                    // تبدیل تاریخ شمسی به میلادی برای ارسال به سرور
                    var gregorianDate = new persianDate(unix).toCalendar('gregorian').format('YYYY-MM-DD');
                    $('#gregorian_date').val(gregorianDate);
                    
                    // نمایش تاریخ شمسی انتخاب شده
                    var persianDate = new persianDate(unix).format('dddd DD MMMM YYYY');
                    $('#selected_date_display').text('تاریخ انتخاب شده: ' + persianDate);
                    
                    console.log('Persian date:', persianDate);
                    console.log('Gregorian date:', gregorianDate);
                }
            };

            // راه‌اندازی تاریخ‌شمار
            try {
                $('#date').persianDatepicker(datepickerOptions);
                console.log('Datepicker initialized');
            } catch (error) {
                console.error('Error initializing datepicker:', error);
            }
        });
    </script>
    @endpush
</x-app-layout> 