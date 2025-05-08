<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Restaurant Menu') }} - {{ $restaurant->name }}
            </h2>
            <a href="{{ route('restaurants.menus.create', $restaurant) }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add Menu Item
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($menus->isEmpty())
                        <div class="text-center py-6">
                            <p class="text-gray-600">No menu items found.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-6">
                            @foreach($menus->groupBy('category') as $category => $items)
                                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 capitalize">{{ $category }}</h3>
                                    <div class="space-y-4">
                                        @foreach($items as $menu)
                                            <div class="flex justify-between items-start border-b border-gray-200 pb-4">
                                                <div>
                                                    <h4 class="text-md font-medium">{{ $menu->name }}</h4>
                                                    @if($menu->description)
                                                        <p class="text-sm text-gray-600 mt-1">{{ $menu->description }}</p>
                                                    @endif
                                                    <p class="text-sm text-gray-500 mt-1">${{ number_format($menu->price, 2) }}</p>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('restaurants.menus.edit', [$restaurant, $menu]) }}"
                                                       class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <form action="{{ route('restaurants.menus.destroy', [$restaurant, $menu]) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Are you sure you want to delete this menu item?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
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