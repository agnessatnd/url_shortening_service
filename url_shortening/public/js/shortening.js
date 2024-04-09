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

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-url');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const urlId = this.getAttribute('data-url-id');
            deleteUrl(urlId);
        });
    });
});

