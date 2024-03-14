<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <script src="https://kit.fontawesome.com/206ca5c866.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/shortening.js') }}"></script>
        <link href="{{ asset('css/shortening.css') }}" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    </head>
    <body class="antialiased">
    <div id="notification" class="notification"></div>

    <div class="navbar">
        <a href="/">TPT Link</a>
        <a class="login">Logi sisse</a>
    </div>
    <div class="form-container">
        <form action="/shortening" method="post" class="form">
            @csrf
            <h2>Lingi lühendamine</h2>
            <input type="text" class="input" name="url" placeholder="Sisestage link">
            <button type="submit" class="button">Lühenda link</button>
            @if(session('shortenedURL'))
                <input type="text" id="shortened_url" class="input2" name="shortened" readonly value="{{ session('shortenedURL') }}">
            <a onclick='copy()'><i class="fa-regular fa-copy" title="kopeeri link"></i></a>
            @endif
        </form>
    </div>
</body>
</html>
