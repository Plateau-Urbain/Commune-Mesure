<script>
document.addEventListener('click', function(e) {
    // loop parent nodes from the target to the delegation node
    for (var target = e.target; target && target != this; target = target.parentNode) {
        if (target.matches('.modal-crayon') || target.matches('#modal-help-btn') || target.matches('.bars_param')) {
            ouvrirModale.call(target, e);
            break;
        }
    }
}, false)

function ouvrirModale(target){
  modal = target.target.dataset.modal
  document.getElementById(modal).classList.add('is-active')
}

document.addEventListener('click', function(e){
  for (var target = e.target; target && target != this; target = target.parentNode) {
      if (target.matches('.modal-croix')) {
          fermerModale.call(target, e);
          break;
      }
  }

}, false)


function fermerModale(target){
  var elems = document.querySelectorAll(".is-active");
  [].forEach.call(elems, function(el) {
    el.classList.remove("is-active");
  });
}
</script>
