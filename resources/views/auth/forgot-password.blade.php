<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-600">
        {{ __('Lupa kata sandi Anda? Tidak masalah. Cukup beritahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi yang akan memungkinkan Anda memilih yang baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" class="text-dark" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full bg-white text-dark" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                <span class="text-dark">
                    {{ __('Email Password Reset Link') }}

                </span>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
