function copy() {
    var copyText = document.getElementById("shortened_url");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);

    var notification = document.getElementById("notification");
    notification.innerText = "Link kopeeritud lõikelauale!";
    notification.style.display = "block";

    setTimeout(function(){
        notification.style.display = "none";
    }, 3000);
}
