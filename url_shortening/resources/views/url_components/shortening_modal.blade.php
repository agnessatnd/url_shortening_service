<div class="flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full md:w-auto">
        <form action="{{ route('shorten') }}" method="post" class="flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4" style="width: 800px;">
            @csrf
            <h2 class="text-2xl font-bold mb-4">Lingi lühendamine</h2><br>
            <div class="flex w-full md:w-auto">
                <input type="text" id="urlInput" name="url" placeholder="Sisestage link" class="flex-1 px-4 py-2 border border-gray-300 rounded mb-4 mr-2" oninput="checkInput()">
                <button type="submit" id="shortenButton" name="shorten_button" class="w-auto md:w-32 h-10 bg-blue-500 text-white font-semibold px-4 py-2 rounded" disabled>Lühenda link</button>
            </div>
        </form>
        @if(session('shortenedURL'))
            <div id="modal" class="modal fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="modal-dialog bg-white p-10 rounded-lg shadow-lg w-4/6 overflow-y-auto">
                    <div class="modal-header border-b pb-2 mb-4">
                        <h1 class="modal-title text-lg font-semibold">Lühendatud link</h1>
                        <button type="button" class="modal-close absolute top-2 right-2 text-gray-500 hover:text-gray-700" onclick="closeShorteningModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form id="shortenedUrlForm" action="{{ route('saveShortenedUrl') }}" method="post">
                        @csrf
                        <div id="error-message" class="hidden text-red-500"></div>
                        <div class="modal-body flex flex-col">
                        <input type="hidden" name="shortened_url_id" value="{{ session('shortenedUrlId') }}">
                            <div class="flex items-center mb-2">
                                <input type="text" id="short-link-prefix" class="px-4 py-1 h-10 border border-gray-300 rounded mr-2 w-1/3" value="http://127.0.0.1:8000/{{ session('shortenedUrlId') }}" disabled>
                                <input type="text" id="shortenedUrl" name="short_url" value="{{ session('shortenedURL') }}" class="px-4 py-1 h-10 border border-gray-300 rounded w-full">
                                <button type="button" onclick="copyToClipboard()" class="text-blue-500 hover:text-blue-700 mr-2">
                                    <i class="far fa-copy"></i>
                                </button>
                            </div>
                            <div class="flex items-center mb-2">
                                <label class="block text-base font-medium text-gray-700 mr-2">Kehtib kuni:</label>
                                <input type="date" id="datepicker" name="expiration_date" class="px-4 py-1 h-10 border border-gray-300 rounded mr-2">
                                <input type="time" id="timepicker" name="expiration_time" class="px-4 py-1 h-10 border border-gray-300 rounded">
                            </div>
                        </div>
                        <div class="modal-footer flex justify-end pt-4 border-t">
                            <button type="submit" class="w-auto bg-blue-500 text-white font-semibold px-4 py-2 rounded mr-2">Salvesta</button>
                            <button type="button" class="w-auto bg-blue-500 text-white font-semibold px-4 py-2 rounded" onclick="closeShorteningModal()">Tühista</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
