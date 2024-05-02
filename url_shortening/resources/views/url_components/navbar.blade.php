<!--Navbar-->
<nav class="bg-blue-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16 ">
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-6">
                @guest
                    <a href="{{ route('login') }}" class="text-white">TPT Link</a>
                @else
                    <a href="/shortening" class="text-white">TPT Link</a>
                @endguest
            </div>
            <div class="flex-shrink-0 mr-4">
                @guest
                    <a href="{{ route('login') }}" class="text-white">Lühendatud lingid</a>
                @else
                    <a href="/url_table" class="text-white">Lühendatud lingid</a>
                @endguest
            </div>
        </div>
        <div class="flex items-center space-x-4">
            @guest
                <a href="{{ route('login') }}" class="text-white">Logi sisse</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-white">Registreeri</a>
                @endif
            @else
            @include('url_components/user_dropdown')
            @endguest
        </div>
    </div>
</nav>
