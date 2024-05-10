<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Täname registreerimise eest! Enne alustamist palun kinnitage oma e-posti aadress, klõpsates lingile, mille me just Teile meiliga saatsime. Kui te ei saanud meili, saadame teile hea meelega uue!') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('Uus kinnitamise link on saadetud e-posti aadressile, mille te registreerimisel esitasite') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <button type='submit' class="bg-blue-500 text-white font-semibold px-4 py-2 rounded">
                    {{ __('Saada uuesti kinnitamise e-kiri') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div>
                <button type='submit' class="bg-red-500 text-white font-semibold px-4 py-2 rounded">
                    {{ __('Logi välja') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
