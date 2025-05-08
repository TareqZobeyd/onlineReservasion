<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('مدیریت رستوران‌ها') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">لیست رستوران‌ها</h3>
                        <a href="{{ route('admin.restaurants.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            افزودن رستوران جدید
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نام</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">آدرس</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تلفن</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تعداد رزروها</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عملیات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($restaurants as $restaurant)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $restaurant->name }}</td>
                                    <td class="px-6 py-4">{{ $restaurant->address }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $restaurant->phone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($restaurant->status === 'active') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $restaurant->status === 'active' ? 'فعال' : 'غیرفعال' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $restaurant->reservations_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.restaurants.edit', $restaurant) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">ویرایش</a>
                                        <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('آیا از حذف این رستوران اطمینان دارید؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $restaurants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 