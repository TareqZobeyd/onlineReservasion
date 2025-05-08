<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            رزرو میز در {{ $restaurant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">اطلاعات رزرو</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">تاریخ:</span>
                                <span>{{ \Carbon\Carbon::parse($date)->format('Y/m/d') }}</span>
                            </div>
                            <div>
                                <span class="font-medium">ساعت:</span>
                                <span>{{ $time }}</span>
                            </div>
                            <div>
                                <span class="font-medium">تعداد مهمان:</span>
                                <span>{{ $guests }} نفر</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('reservations.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                        <input type="hidden" name="reservation_date" value="{{ $date }}">
                        <input type="hidden" name="reservation_time" value="{{ $time }}">
                        <input type="hidden" name="number_of_guests" value="{{ $guests }}">

                        <div>
                            <label for="special_requests" class="block text-sm font-medium text-gray-700">درخواست‌های ویژه</label>
                            <textarea name="special_requests" id="special_requests" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                      placeholder="درخواست‌های ویژه خود را اینجا بنویسید..."></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                ثبت رزرو
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 