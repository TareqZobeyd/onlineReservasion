<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            جزئیات رزرو
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">اطلاعات رزرو</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">رستوران</h4>
                                <p class="text-gray-600">{{ $reservation->restaurant->name }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">وضعیت</h4>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($reservation->status === 'pending')
                                        bg-yellow-100 text-yellow-800
                                    @elseif($reservation->status === 'confirmed')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif">
                                    @if($reservation->status === 'pending')
                                        در انتظار تأیید
                                    @elseif($reservation->status === 'confirmed')
                                        تأیید شده
                                    @else
                                        لغو شده
                                    @endif
                                </span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">تاریخ و ساعت</h4>
                                <p class="text-gray-600">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y/m/d') }}
                                    ساعت {{ $reservation->reservation_time }}
                                </p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">تعداد مهمان</h4>
                                <p class="text-gray-600">{{ $reservation->number_of_guests }} نفر</p>
                            </div>
                            @if($reservation->special_requests)
                                <div class="col-span-full">
                                    <h4 class="font-medium text-gray-700 mb-2">درخواست‌های ویژه</h4>
                                    <p class="text-gray-600">{{ $reservation->special_requests }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 space-x-reverse">
                        @if($reservation->status === 'pending')
                            <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        onclick="return confirm('آیا از لغو رزرو اطمینان دارید؟')">
                                    لغو رزرو
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('restaurants.show', $reservation->restaurant) }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            بازگشت به رستوران
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 