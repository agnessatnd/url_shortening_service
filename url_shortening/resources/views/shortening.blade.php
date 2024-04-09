<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TPT Link</title>
    @vite('resources/css/app.css')
    <script src="https://kit.fontawesome.com/206ca5c866.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/shortening.js') }}"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-gray-100">
<div id="notification" class="notification"></div>

<nav class="bg-blue-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16 ">
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-6">
                <a href="/shortening" class="text-white">TPT Link</a>
            </div>
            <div class="flex-shrink-0 mr-4">
                <a href="/url_table" class="text-white">Lühendatud lingid</a>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            @guest
                <a href="{{ route('login') }}" class="text-white">Logi sisse</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-white">Registreeri</a>
                @endif
            @else
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="text-white">
                    Logi välja
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </div>
    </div>
</nav>
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full md:w-auto">
            <form action="/shortening" method="post" class="flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4" style="width: 800px; height: 200px;">
                @csrf
                <h2 class="text-2xl font-bold mb-4">Lingi lühendamine</h2><br>
                <div class="flex w-full md:w-auto">
                    <input type="text" name="url" placeholder="Sisestage link" class="flex-1 px-4 py-2 border border-gray-300 rounded mb-4 mr-2">
                    <button type="submit" name="shorten_button" class="w-auto md:w-32 h-10 bg-blue-500 text-white font-semibold px-4 py-2 rounded">
                        Lühenda link
                    </button>
                </div>
                    <div class="flex items-center">
                        <input type="text" id="shortened_url" name="shortened" readonly value="{{ session('shortenedURL') }}" class="w-full px-4 py-2 border border-gray-300 rounded mt-4">
                        @if(session('shortenedURL')) <button onclick="copy()" type="button" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 ml-2">
                        <i class="far fa-copy"></i> @endif
                        </button>
                    </div>
            </form>
        </div>
    </div>
</body>
</html>
