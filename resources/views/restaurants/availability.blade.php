<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            میزهای موجود در {{ $restaurant->name }}
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

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($availableTables as $table)
                            <div class="bg-white border rounded-lg shadow-sm p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold">میز شماره {{ $table->table_number }}</h4>
                                        <p class="text-gray-600">ظرفیت: {{ $table->capacity }} نفر</p>
                                        @if($table->location)
                                            <p class="text-gray-600">موقعیت: {{ $table->location }}</p>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('restaurant.reservations.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                                    <input type="hidden" name="table_id" value="{{ $table->id }}">
                                    <input type="hidden" name="reservation_date" value="{{ $date }}">
                                    <input type="hidden" name="reservation_time" value="{{ $time }}">
                                    <input type="hidden" name="number_of_guests" value="{{ $guests }}">
                                    <button type="submit" 
                                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        رزرو میز
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 