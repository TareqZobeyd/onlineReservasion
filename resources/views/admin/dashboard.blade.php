<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('داشبورد ادمین') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- آمار کلی -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-xl mb-2">تعداد رستوران‌ها</div>
                    <div class="text-3xl font-bold text-purple-600">{{ $stats['total_restaurants'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-xl mb-2">تعداد کاربران</div>
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['total_users'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-xl mb-2">تعداد رزروها</div>
                    <div class="text-3xl font-bold text-green-600">{{ $stats['total_reservations'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-xl mb-2">تعداد نظرات</div>
                    <div class="text-3xl font-bold text-yellow-600">{{ $stats['total_reviews'] }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- نمودار رزروها در 7 روز گذشته -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">رزروها در 7 روز گذشته</h3>
                        <canvas id="reservationsChart" height="300"></canvas>
                    </div>
                </div>

                <!-- نمودار وضعیت رزروها -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">وضعیت رزروها</h3>
                        <canvas id="reservationsStatusChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- رزروهای اخیر -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">رزروهای اخیر</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">کاربر</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رستوران</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentReservations as $reservation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->restaurant->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->created_at->format('Y/m/d H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($reservation->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $reservation->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- نظرات اخیر -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">نظرات اخیر</h3>
                        <div class="space-y-4">
                            @foreach($stats['recent_reviews'] as $review)
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $review->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $review->restaurant->name }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-yellow-400">★</span>
                                        <span class="ml-1 text-sm text-gray-600">{{ $review->rating }}</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">{{ $review->comment }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- رستوران‌های پربازدید -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">رستوران‌های پربازدید</h3>
                    <div class="space-y-4">
                        @foreach($popular_restaurants as $restaurant)
                            <div class="border-b pb-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-medium">{{ $restaurant->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $restaurant->address }}</div>
                                    </div>
                                    <div class="text-sm">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">
                                            {{ $restaurant->reservations_count }} رزرو
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- نمودار رزروهای ماهانه -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">رزروهای ماهانه</h3>
                    <div class="h-64">
                        <canvas id="monthlyReservationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // نمودار رزروها در 7 روز گذشته
        const reservationsCtx = document.getElementById('reservationsChart').getContext('2d');
        new Chart(reservationsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($reservations_by_day->pluck('date')) !!},
                datasets: [{
                    label: 'تعداد رزرو',
                    data: {!! json_encode($reservations_by_day->pluck('total')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // نمودار وضعیت رزروها
        const statusCtx = document.getElementById('reservationsStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($reservations_by_status->pluck('status')) !!},
                datasets: [{
                    data: {!! json_encode($reservations_by_status->pluck('total')) !!},
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(234, 179, 8)',
                        'rgb(239, 68, 68)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        const ctx = document.getElementById('monthlyReservationsChart').getContext('2d');
        const monthlyData = @json($monthlyReservations);
        
        const months = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
        const data = Array(12).fill(0);
        
        monthlyData.forEach(item => {
            data[item.month - 1] = item.count;
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'تعداد رزرو',
                    data: data,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout> 