function copy() {
    var copyText = document.getElementById("shortened_url");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    copyText.focus();
    navigator.clipboard.writeText(copyText.value);

    var notification = document.getElementById("notification");
    notification.innerText = "Link kopeeritud lõikelauale!";
    notification.style.display = "block";

    setTimeout(function(){
        notification.style.display = "none";
    }, 3000);
}

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
            console.error('Kustutamise tõrge:', error);
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
    document.getElementById('modal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
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
                console.error('Error:', error);
                alert('Midagi läks valesti. Palun proovige uuesti.');
            });
        });
    });
});
