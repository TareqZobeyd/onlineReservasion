<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ویرایش منو') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('restaurant.menus.update', $menu) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('نام منو')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                :value="old('name', $menu->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('توضیحات')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ old('description', $menu->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="category" :value="__('دسته‌بندی')" />
                            <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" 
                                :value="old('category', $menu->category)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('category')" />
                        </div>

                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                    {{ old('is_active', $menu->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="mr-2 text-sm text-gray-600">فعال</span>
                            </label>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('بروزرسانی') }}</x-primary-button>
                            <a href="{{ route('restaurant.menus.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('انصراف') }}
                            </a>
                        </div>
                    </form>

                    <!-- مدیریت آیتم‌های منو -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">آیتم‌های منو</h3>
                        
                        <div class="space-y-4">
                            @forelse($menu->items as $item)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <div class="font-medium">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->description }}</div>
                                        <div class="text-sm text-gray-500">{{ number_format($item->price) }} تومان</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('restaurant.menu-items.edit', [$menu, $item]) }}" 
                                            class="text-indigo-600 hover:text-indigo-900">ویرایش</a>
                                        <form action="{{ route('restaurant.menu-items.destroy', [$menu, $item]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('آیا از حذف این آیتم اطمینان دارید؟')">
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-4">هیچ آیتمی در این منو وجود ندارد</div>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('restaurant.menu-items.create', $menu) }}" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                افزودن آیتم جدید
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 