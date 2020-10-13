var blocs = document.querySelectorAll(".is-clickable")
for (i = 0; i < blocs.length; i++) {
    blocs[i].addEventListener('click', function() {
        this.querySelector('a').click();
    });
}
