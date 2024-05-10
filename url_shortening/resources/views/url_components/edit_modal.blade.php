@foreach($urls as $editUrl)
        @if ($editUrl)
            <div id="dialog-{{ $editUrl->id }}" class="modal fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
                <div class="modal-dialog bg-white p-10 rounded-lg shadow-lg w-4/6 overflow-y-auto">
                    <div class="modal-header border-b pb-2 mb-4">
                        <h1 class="modal-title text-lg font-semibold">Muuda andmeid</h1>
                        <button type="button" class="modal-close absolute top-2 right-2 text-gray-500 hover:text-gray-700" onclick="closeDialog({{ $editUrl->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form id="update-form-{{ $editUrl->id }}" action="/update_custom_link/{{ $editUrl->id }}" method="POST" data-modal-id="dialog-{{ $editUrl->id }}">
                        @csrf
                        <div id="error-message" class="hidden text-red-500"></div>
                        <div class="flex mb-4">
                            <input type="text" id="short-link-prefix" class="px-4 py-2 border border-gray-300 rounded mr-2 w-1/3" value="http://127.0.0.1:8000/" disabled>
                            <div class="modal-body flex-1">
                                <input type="text" id="custom-link-end" name="short_url" value="{{ $editUrl->short_url }}" placeholder="Sisestage kohandatud link" class="px-4 py-2 border border-gray-300 rounded w-full">
                            </div>
                        </div>
                        <div class="flex items-center mb-2">
                            <label class="block text-base font-medium text-gray-700 mr-2">Kehtib kuni:</label>
                            <input type="date" id="datepicker" name="expiration_date" class="px-4 py-1 h-10 border border-gray-300 rounded mr-2" value="{{ $editUrl->expiration_date ? date('Y-m-d', strtotime($editUrl->expiration_date)) : '' }}">
                            <input type="time" id="timepicker" name="expiration_time" class="px-4 py-1 h-10 border border-gray-300 rounded" value="{{ $editUrl->expiration_date ? date('H:i', strtotime($editUrl->expiration_date)) : '' }}">
                        </div>
                        <div class="modal-footer flex justify-end pt-4 border-t">
                            <button type="submit" class="w-auto bg-blue-500 text-white font-semibold px-4 py-2 rounded mr-2 save-button">Salvesta</button>
                            <button type="button" class="w-auto bg-blue-500 text-white font-semibold px-4 py-2 rounded" onclick="closeModal('{{ $editUrl->id }}')">Tühista</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endforeach
