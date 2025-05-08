<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('مدیریت نظرات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex flex-wrap gap-4">
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
                                <label for="rating" class="block text-sm font-medium text-gray-700">امتیاز</label>
                                <select name="rating" id="rating"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">همه امتیازها</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                            {{ $i }} ستاره
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="flex-1">
                                <label for="status" class="block text-sm font-medium text-gray-700">وضعیت</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">همه وضعیت‌ها</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>تایید شده</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>رد شده</option>
                                </select>
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
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">امتیاز</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نظر</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reviews as $review)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $review->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $review->restaurant->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($review->comment, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($review->status === 'approved') bg-green-100 text-green-800
                                            @elseif($review->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $review->status === 'approved' ? 'تایید شده' : 
                                               ($review->status === 'pending' ? 'در انتظار تایید' : 'رد شده') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $review->created_at->format('Y/m/d') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.reviews.show', $review) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">مشاهده</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 