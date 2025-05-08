<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('داشبورد رستوران') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- آمار کلی -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 mb-2">کل رزروها</div>
                        <div class="text-2xl font-bold">{{ $stats['total_reservations'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 mb-2">رزروهای امروز</div>
                        <div class="text-2xl font-bold">{{ $stats['today_reservations'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 mb-2">رزروهای در انتظار</div>
                        <div class="text-2xl font-bold">{{ $stats['pending_reservations'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 mb-2">میانگین امتیاز</div>
                        <div class="text-2xl font-bold">{{ number_format($stats['average_rating'], 1) }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- رزروهای اخیر -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">رزروهای اخیر</h3>
                        <div class="space-y-4">
                            @forelse($recentReservations as $reservation)
                                <div class="border-b pb-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="font-medium">{{ $reservation->user->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $reservation->reservation_date->format('Y/m/d') }} - 
                                                {{ $reservation->reservation_time }}
                                            </div>
                                        </div>
                                        <div class="text-sm">
                                            <span class="px-2 py-1 rounded-full
                                                @if($reservation->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $reservation->status === 'confirmed' ? 'تایید شده' : 
                                                   ($reservation->status === 'pending' ? 'در انتظار' : 'لغو شده') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-4">هیچ رزروی یافت نشد</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- نمودار رزروهای هفتگی -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">رزروهای هفتگی</h3>
                        <div class="h-64">
                            <canvas id="weeklyReservationsChart"></canvas>
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

                <!-- وضعیت رزروها -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">وضعیت رزروها</h3>
                        <div class="h-64">
                            <canvas id="reservationsStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // نمودار رزروهای هفتگی
        const weeklyCtx = document.getElementById('weeklyReservationsChart').getContext('2d');
        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($reservations_by_day->pluck('date')) !!},
                datasets: [{
                    label: 'تعداد رزرو',
                    data: {!! json_encode($reservations_by_day->pluck('total')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // نمودار رزروهای ماهانه
        const monthlyCtx = document.getElementById('monthlyReservationsChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyReservations->pluck('month')) !!},
                datasets: [{
                    label: 'تعداد رزرو',
                    data: {!! json_encode($monthlyReservations->pluck('total')) !!},
                    backgroundColor: 'rgb(59, 130, 246)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
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
                        'rgb(34, 197, 94)',  // سبز برای تایید شده
                        'rgb(234, 179, 8)',  // زرد برای در انتظار
                        'rgb(239, 68, 68)'   // قرمز برای لغو شده
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
    @endpush
</x-app-layout> 