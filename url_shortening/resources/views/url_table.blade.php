<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TPT Link</title>
    @vite('resources/css/app.css')
    <script src="https://kit.fontawesome.com/206ca5c866.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/shortening.js') }}"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <script src="{{ asset('js/shortening.js') }}"></script>
</head>
<body class="antialiased bg-gray-100">
<div id="notification" class="notification"></div>
<nav class="bg-blue-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
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
    </div>
</nav>
<div class="mb-4 mt-8">
    <div class="container mx-auto">
        <table class="min-w-full divide-y divide-gray-200" style="width: 100%;">
            <thead>
                <tr>
                <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider" style="max-width: 300px;">Originaal link</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Lühendatud link</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Lisatud</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Klikid</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Muudetud</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Muuda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($url as $url)
                    <tr class="bg-gray-200 hover:bg-gray-300">
                        <td class="px-6 py-4 whitespace-wrap" style="max-width: 300px; overflow-wrap: break-word;">{{ $url->original_url }}</td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">http://127.0.0.1:8000/{{ $url->short_url }}</td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">{{ $url->created_at }}</td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">{{ $url->clicks }}</td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">{{ $url->updated_at }}</td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">
                            <a href="" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="" class="text-blue-500 hover:text-blue-700" data-url-id="{{ $url->id }}" onclick="deleteUrl({{ $url->id }}); return false;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
