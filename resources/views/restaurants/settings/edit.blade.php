<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Restaurant Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('restaurants.settings.update', $restaurant) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Working Hours</h3>
                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-700 capitalize">{{ $day }}</label>
                                        <div class="mt-2 grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm text-gray-500">Open</label>
                                                <input type="time" 
                                                       name="working_hours[{{ $day }}][open]" 
                                                       value="{{ $settings->working_hours[$day]['open'] ?? '' }}"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-500">Close</label>
                                                <input type="time" 
                                                       name="working_hours[{{ $day }}][close]" 
                                                       value="{{ $settings->working_hours[$day]['close'] ?? '' }}"
                                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Holidays</h3>
                            <div class="mt-4">
                                <div id="holidays-container">
                                    @foreach($settings->holidays ?? [] as $holiday)
                                        <div class="holiday-item flex items-center gap-2 mb-2">
                                            <input type="date" 
                                                   name="holidays[]" 
                                                   value="{{ $holiday }}"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="button" 
                                                    onclick="this.parentElement.remove()"
                                                    class="text-red-600 hover:text-red-800">
                                                Remove
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" 
                                        onclick="addHolidayField()"
                                        class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Add Holiday
                                </button>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Reservation Settings</h3>
                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Minimum Notice (minutes)</label>
                                    <input type="number" 
                                           name="min_reservation_notice" 
                                           value="{{ $settings->min_reservation_notice }}"
                                           min="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Maximum Notice (minutes)</label>
                                    <input type="number" 
                                           name="max_reservation_notice" 
                                           value="{{ $settings->max_reservation_notice }}"
                                           min="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Max Guests per Reservation</label>
                                    <input type="number" 
                                           name="max_guests_per_reservation" 
                                           value="{{ $settings->max_guests_per_reservation }}"
                                           min="1"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       {{ $settings->is_active ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Restaurant is active</span>
                            </label>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function addHolidayField() {
            const container = document.getElementById('holidays-container');
            const div = document.createElement('div');
            div.className = 'holiday-item flex items-center gap-2 mb-2';
            div.innerHTML = `
                <input type="date" 
                       name="holidays[]" 
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <button type="button" 
                        onclick="this.parentElement.remove()"
                        class="text-red-600 hover:text-red-800">
                    Remove
                </button>
            `;
            container.appendChild(div);
        }
    </script>
    @endpush
</x-app-layout> 