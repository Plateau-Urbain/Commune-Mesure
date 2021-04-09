var blocs = document.querySelectorAll(".is-clickable")
for (i = 0; i < blocs.length; i++) {
    blocs[i].addEventListener('click', function() {
        this.querySelector('a').click();
    });
}

function toggle(source) {
checkboxes = document.getElementsByClassName('check');
for(var i=0, n=checkboxes.length;i<n;i++) {
  checkboxes[i].checked = source.checked;
  }
}
