<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('حذف حساب کاربری') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('پس از حذف حساب کاربری، تمام منابع و داده‌های شما برای همیشه حذف خواهند شد. قبل از حذف حساب کاربری، لطفاً هر داده یا اطلاعاتی که می‌خواهید حفظ کنید را دانلود کنید.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('حذف حساب کاربری') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('آیا مطمئن هستید که می‌خواهید حساب کاربری خود را حذف کنید؟') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('لطفاً رمز عبور خود را وارد کنید تا تایید کنید که می‌خواهید حساب کاربری خود را برای همیشه حذف کنید.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('رمز عبور') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('رمز عبور') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('انصراف') }}
                </x-secondary-button>

                <x-danger-button class="mr-3">
                    {{ __('حذف حساب کاربری') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
