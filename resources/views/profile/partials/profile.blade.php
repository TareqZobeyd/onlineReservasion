<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('اطلاعات پروفایل') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('اطلاعات حساب کاربری شما') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <h3 class="text-sm font-medium text-gray-900">{{ __('نام') }}</h3>
            <p class="mt-1 text-sm text-gray-600">{{ $user->name }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-900">{{ __('ایمیل') }}</h3>
            <p class="mt-1 text-sm text-gray-600">{{ $user->email }}</p>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('ویرایش پروفایل') }}
            </a>
        </div>
    </div>
</section> 