<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Kustuta konto') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Kui teie konto on kustutatud, kustutatakse kõik selle ressursid ja andmed jäädavalt.') }}
        </p>
    </header>

    <button class="bg-red-500 text-white font-semibold px-4 py-2 rounded"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Kustuta konto') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Kas olete kindel, et soovite oma konto kustutada?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Kui teie konto on kustutatud, kustutatakse kõik selle ressursid ja andmed jäädavalt. Palun sisestage oma parool, et kinnitada, et soovite oma konto jäädavalt kustutada.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Parool') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Parool') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Loobu') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Kustuta konto') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
