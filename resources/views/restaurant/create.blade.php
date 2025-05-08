<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ثبت رستوران جدید') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('restaurant.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('نام رستوران')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('توضیحات')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('آدرس')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div>
                            <x-input-label for="phone_number" :value="__('شماره تماس')" />
                            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                        </div>

                        <div>
                            <x-input-label for="cuisine_type" :value="__('نوع غذا')" />
                            <x-text-input id="cuisine_type" name="cuisine_type" type="text" class="mt-1 block w-full" :value="old('cuisine_type')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('cuisine_type')" />
                        </div>

                        <div>
                            <x-input-label for="price_range" :value="__('محدوده قیمت')" />
                            <select id="price_range" name="price_range" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="budget">اقتصادی</option>
                                <option value="moderate">متوسط</option>
                                <option value="expensive">گران</option>
                                <option value="luxury">لوکس</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('price_range')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="opening_time" :value="__('ساعت شروع کار')" />
                                <x-text-input id="opening_time" name="opening_time" type="time" class="mt-1 block w-full" :value="old('opening_time')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('opening_time')" />
                            </div>

                            <div>
                                <x-input-label for="closing_time" :value="__('ساعت پایان کار')" />
                                <x-text-input id="closing_time" name="closing_time" type="time" class="mt-1 block w-full" :value="old('closing_time')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('closing_time')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('تصویر رستوران')" />
                            <input type="file" id="image" name="image" class="mt-1 block w-full" accept="image/*">
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('ثبت رستوران') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 