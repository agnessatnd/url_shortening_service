<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TPT Link</title>
    <script src="https://kit.fontawesome.com/206ca5c866.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/shortening.js') }}"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
@include('url_components/navbar')
@include('url_components/shortening_modal')
</body>
</html>
