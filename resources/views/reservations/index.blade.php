<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Reservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($reservations->isEmpty())
                        <div class="text-center py-6">
                            <p class="text-gray-600">You don't have any reservations yet.</p>
                            <a href="{{ route('restaurants.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-900">
                                Browse Restaurants
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-6">
                            @foreach($reservations as $reservation)
                                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold mb-2">{{ $reservation->restaurant->name }}</h3>
                                            <p class="text-gray-600 mb-2">Table {{ $reservation->table->number }}</p>
                                            <p class="text-gray-600 mb-2">
                                                Date: {{ $reservation->reservation_date->format('F j, Y') }}<br>
                                                Time: {{ $reservation->reservation_time->format('g:i A') }}<br>
                                                Guests: {{ $reservation->number_of_guests }}
                                            </p>
                                            <p class="text-sm">
                                                Status: 
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                    @if($reservation->status === 'confirmed') bg-green-100 text-green-800
                                                    @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($reservation->status) }}
                                                </span>
                                            </p>
                                        </div>
                                        @if($reservation->status === 'pending')
                                            <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="ml-4">
                                                @csrf
                                                <button type="submit"
                                                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 