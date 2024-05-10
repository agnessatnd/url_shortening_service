<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TPT Link</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/206ca5c866.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/shortening.js') }}"></script>
</head>
<body class="antialiased bg-gray-100">
<div id="notification" class="notification"></div>
@include('url_components/navbar')
<div class="mb-4 mt-8">
<div id="delete-button-container" class="flex justify-end mb-4">
    <div id="delete-button" style="display: none;">
        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="deleteSelectedRows()">Kustuta valitud</button>
    </div>
</div>
    <div class="container mx-auto overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200" style="width: 100%;">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">
                        <input type="checkbox" id="select-all" class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out" onchange="toggleAllCheckboxes(this)">
                        <label for="select-all" class="ml-2 text-blue-600 cursor-pointer">Vali kõik</label>
                    </th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider" style="max-width: 300px;">Originaal link</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Lühendatud link</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Lisatud</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Külastuste arv</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Kehtib kuni</th>
                    <th class="px-6 py-3 bg-white text-left text-xs leading-4 font-medium text-gray-800 uppercase tracking-wider">Muuda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($urls as $url)
                    <tr class="bg-gray-200 hover:bg-gray-300">
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">
                            <input type="checkbox" class="row-checkbox" value="{{ $url->id }}" onchange="toggleDeleteButton()">
                        </td>
                        <td class="px-6 py-4 whitespace-wrap" style="max-width: 300px; overflow-wrap: break-word;">{{ $url->original_url }}</td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">
                            http://127.0.0.1:8000/{{ $url->short_url }}
                            <button class="text-blue-500 hover:text-blue-700 ml-2" title="Kopeeri" onclick="copyShortUrl('{{ $url->short_url }}')">
                                <i class="far fa-copy"></i>
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">{{ date('H:i d.m.Y', strtotime($url->created_at)) }}</td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">{{ $url->clicks }}</td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">
                        @if($url->expiration_date)
                            {{ date('H:i d.m.Y', strtotime($url->expiration_date)) }}
                        @endif
                        </td>
                        <td class="px-6 py-4 whitespace-wrap" style="word-wrap: break-word;">
                            <a href="#" class="text-blue-500 hover:text-blue-700 edit-url" title="Muuda" data-url-id="{{ $url->id }}" data-dialog-id="dialog-{{ $url->id }}" onclick="openDialog('dialog-{{ $url->id }}')">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="" class="text-blue-500 hover:text-blue-700" title="Kustuta" data-url-id="{{ $url->id }}" onclick="deleteUrl({{ $url->id }}); return false;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('url_components/edit_modal')
</div>
</body>
</html>
