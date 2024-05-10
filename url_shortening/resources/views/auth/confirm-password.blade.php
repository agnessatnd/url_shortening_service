<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('See on rakenduse turvaline ala. Palun kinnitage oma parool, enne jätkamist.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <button class="bg-blue-500 text-white font-semibold px-4 py-2 rounded">
                {{ __('Kinnita') }}
            </button>
        </div>
    </form>
</x-guest-layout>
