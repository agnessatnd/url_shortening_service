function copyShortUrl(shortUrl) {
    const fullUrl = 'http://127.0.0.1:8000/' + shortUrl;

    navigator.clipboard.writeText(fullUrl)
        .then(() => {
            alert('Link kopeeritud lõikelauale: ' + fullUrl);
        })
        .catch(err => {
            console.error('Tekkis viga kopeerimisel: ', err);
            alert('Kopeerimisel tekkis viga');
        });
}

function copyToClipboard() {
    var prefix = document.getElementById("short-link-prefix").value;
    var shortenedUrl = document.getElementById("shortenedUrl").value;
    var fullUrl = prefix + shortenedUrl;
    navigator.clipboard.writeText(fullUrl).then(function() {
        alert('Link kopeeritud lõikelauale: ' + fullUrl);
    }, function(err) {
        alert('Kopeerimisel tekkis viga');
    });
}

function checkInput() {
    var urlInput = document.getElementById('urlInput');
    var shortenButton = document.getElementById('shortenButton');

    if (urlInput.value === '') {
        shortenButton.disabled = true;
    } else {
        shortenButton.disabled = false;
    }
}


function deleteUrl(urlId) {
    if (confirm('Kas olete kindel, et soovite seda URL-i kustutada?')) {
        fetch(`/url_table/${urlId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                alert('URL kustutatud edukalt');
                location.reload();
            } else {
                alert('URL-i kustutamine ebaõnnestus');
            }
        })
        .catch(error => {
            alert('Midagi läks valesti. Palun proovige uuesti.');
        });
    }
}

function openDialog(dialogId) {
    document.getElementById(dialogId).classList.remove("hidden");
}

function closeModal(id) {
    const modal = document.getElementById(`dialog-${id}`);
    modal.classList.add('hidden');
}

function openShorteningModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeShorteningModal() {
    var modal = document.getElementById('modal');
    modal.style.display = 'none';
}

function toggleAllCheckboxes(mainCheckbox) {
    var checkboxes = document.querySelectorAll('.row-checkbox');

    checkboxes.forEach(function(checkbox) {
        checkbox.checked = mainCheckbox.checked;
    });

    toggleDeleteButton();
}

function toggleSelectAll(event) {
    event.preventDefault();

    var selectAllCheckbox = document.getElementById('select-all');
    var checkboxes = document.querySelectorAll('.row-checkbox');

    if (selectAllCheckbox.checked) {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    } else {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
    }

    toggleDeleteButton();
}

function toggleDeleteButton() {
    var selectedRows = document.querySelectorAll('input.row-checkbox:checked');
    var deleteButton = document.getElementById('delete-button');

    if (selectedRows.length > 0) {
        deleteButton.style.display = 'block';
    } else {
        deleteButton.style.display = 'none';
    }
}


function deleteSelectedRows() {
    var selectedIds = [];
    var selectedRows = document.querySelectorAll('input.row-checkbox:checked');

    selectedRows.forEach(function(row) {
        selectedIds.push(row.value);
    });

    var formData = new FormData();
    formData.append('selectedIds', JSON.stringify(selectedIds));

    fetch('/delete-selected-rows', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            alert('Read kustutatud edukalt');
            location.reload();
        } else {
            alert('Ridade kustutamine ebaõnnestus');
        }
    })
    .catch(error => console.error('Error:', error));
}

function displayErrorMessage(message) {
    var errorMessageElement = document.getElementById('error-message');
    errorMessageElement.textContent = message;
    errorMessageElement.classList.remove('hidden');
}

function hideErrorMessage() {
    var errorMessageElement = document.getElementById('error-message');
    errorMessageElement.textContent = '';
    errorMessageElement.classList.add('hidden');
}


document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('shortenedUrlForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        fetch(this.getAttribute('action'), {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            if (!response.ok) {
                return response.text().then(function(errorMessage) {
                    throw new Error(errorMessage);
                });
            }
            closeShorteningModal();
            window.location.reload();
        })
        .catch(function(error) {
            if (error.message !== 'Serveri vastuse staatus pole OK') {
                displayErrorMessage('Viga: ' + error.message);
            }
        });

    });

    hideErrorMessage();

    const deleteButtons = document.querySelectorAll('.delete-url');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const urlId = this.getAttribute('data-url-id');
            deleteUrl(urlId);
        });
    });

    const editButtons = document.querySelectorAll('.edit-url');

    editButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const dialogId = this.getAttribute('data-dialog-id');
            openDialog(dialogId);
        });
    });

    const saveButtons = document.querySelectorAll('.save-button');

    saveButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const form = button.closest('form');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server error');
                }
                const modalId = form.getAttribute('data-modal-id');
                const modal = document.getElementById(modalId);
                modal.classList.add('hidden');
                location.reload();
            })
            .catch(error => {
                alert('Midagi läks valesti. Palun proovige uuesti.');
            });
        });
    });
});
