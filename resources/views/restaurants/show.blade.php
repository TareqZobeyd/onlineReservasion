<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $restaurant->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vazirmatn@33.0.3/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
        }
        .rating-stars {
            color: #FFD700;
        }
        .feature-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #EEF2FF;
            color: #4F46E5;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- هدر رستوران -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="relative h-96">
                <img src="{{ $restaurant->image_url }}" alt="{{ $restaurant->name }}" 
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-0 right-0 p-8 text-white">
                    <h1 class="text-4xl font-bold mb-2">{{ $restaurant->name }}</h1>
                    <div class="flex items-center mb-4">
                        <div class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <i class="fas fa-star rating-stars ml-1"></i>
                            <span class="font-semibold">{{ number_format($restaurant->average_rating, 1) }}</span>
                        </div>
                    </div>
                </div>
            </div>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- اطلاعات رستوران -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">درباره رستوران</h2>
                    <p class="text-gray-600 mb-6">{{ $restaurant->description }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center">
                            <div class="feature-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="mr-4">
                                <h3 class="text-sm font-medium text-gray-500">نوع غذا</h3>
                                <p class="text-gray-900">{{ $restaurant->cuisine_type }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="feature-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="mr-4">
                                <h3 class="text-sm font-medium text-gray-500">آدرس</h3>
                                <p class="text-gray-900">{{ $restaurant->address }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="feature-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="mr-4">
                                <h3 class="text-sm font-medium text-gray-500">شماره تماس</h3>
                                <p class="text-gray-900">{{ $restaurant->phone_number }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="mr-4">
                                <h3 class="text-sm font-medium text-gray-500">ساعات کاری</h3>
                                <p class="text-gray-900">{{ $restaurant->opening_time->format('H:i') }} - {{ $restaurant->closing_time->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- نظرات -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">نظرات کاربران</h2>
                    @forelse($restaurant->reviews as $review)
                        <div class="border-b border-gray-200 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                            <div class="flex items-center mb-2">
                                <div class="flex items-center">
                                    <i class="fas fa-star rating-stars ml-1"></i>
                                    <span class="text-gray-800 font-semibold">{{ $review->rating }}</span>
                                </div>
                                <span class="text-gray-500 text-sm mr-4">{{ $review->user->name }}</span>
                            </div>
                            <p class="text-gray-600">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">هنوز نظری ثبت نشده است</p>
                    @endforelse
                </div>
            </div>

            <!-- فرم رزرو -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">رزرو میز</h2>
                    @if(session('error'))
                        <div class="bg-red-50 border-r-4 border-red-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="mr-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('restaurants.check-availability', $restaurant) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">تاریخ</label>
                                <input type="date" name="date" required min="{{ date('Y-m-d') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ساعت</label>
                                <input type="time" name="time" required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">تعداد نفرات</label>
                                <input type="number" name="guests" required min="1" max="20"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <button type="submit" 
                                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                بررسی موجودی
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    
    submitButton.disabled = true;
    submitButton.innerHTML = 'در حال بررسی...';
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.available) {
            // اگر میز موجود باشد، کاربر را به صفحه رزرو هدایت می‌کنیم
            window.location.href = '{{ route("reservations.create") }}';
        } else {
            // نمایش پیام خطا
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('خطایی رخ داد. لطفا دوباره تلاش کنید.');
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
    });
});
</script>
</html> 