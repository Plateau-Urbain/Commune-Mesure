<script>

document.querySelectorAll('.modal').forEach(function(modal) {
  document.getElementById('modal_container').insertAdjacentElement('beforeend',modal);
});

document.addEventListener('click', function(e) {
    // loop parent nodes from the target to the delegation node
    for (var target = e.target; target && target != this; target = target.parentNode) {
        if (target.matches('.modal-crayon')) {
            ouvrirModale.call(target, e);
            break;
        }
    }
}, false)

function ouvrirModale(target){
  console.log(target)
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
  //console.log(target);
  var elems = document.querySelectorAll(".is-active");
  [].forEach.call(elems, function(el) {
    el.classList.remove("is-active");
  });
  //e.target.className = "is-active";
}


</script>
