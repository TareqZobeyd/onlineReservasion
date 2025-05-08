<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('مدیریت رزروها') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <form action="{{ route('admin.reservations.index') }}" method="GET" class="flex flex-wrap gap-4">
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium text-gray-700">جستجو</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="نام کاربر یا رستوران">
                            </div>

                            <div class="flex-1">
                                <label for="restaurant_id" class="block text-sm font-medium text-gray-700">رستوران</label>
                                <select name="restaurant_id" id="restaurant_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">همه رستوران‌ها</option>
                                    @foreach($restaurants as $restaurant)
                                        <option value="{{ $restaurant->id }}" {{ request('restaurant_id') == $restaurant->id ? 'selected' : '' }}>
                                            {{ $restaurant->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-1">
                                <label for="status" class="block text-sm font-medium text-gray-700">وضعیت</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">همه وضعیت‌ها</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>تایید شده</option>
                                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                                </select>
                            </div>

                            <div class="flex-1">
                                <label for="date_from" class="block text-sm font-medium text-gray-700">از تاریخ</label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="flex-1">
                                <label for="date_to" class="block text-sm font-medium text-gray-700">تا تاریخ</label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    فیلتر
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">کاربر</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رستوران</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ رزرو</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ساعت</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تعداد نفرات</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reservations as $reservation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->restaurant->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->reservation_date->format('Y/m/d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->reservation_time }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->guests_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($reservation->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $reservation->status === 'confirmed' ? 'تایید شده' : 
                                               ($reservation->status === 'pending' ? 'در انتظار تایید' : 'لغو شده') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.reservations.show', $reservation) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">مشاهده</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $reservations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 