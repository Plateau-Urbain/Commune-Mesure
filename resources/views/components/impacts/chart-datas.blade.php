<script>
  var i = 0;
  var values;

  function move(element) {
    var width = 10;
    if (i == 0) {
      i = 1;
      var elem = element;
      var id = setInterval(frame, 10);
      var fill = parseInt(element.dataset.fill);
      var full = parseInt(element.dataset.full);
      var widthfill = (fill/full)*100;
      function frame() {
        if (width >= widthfill) {
          clearInterval(id);
          i = 0;
        } else {
          width++;
          elem.style.width = width + "%";
          elem.innerHTML = width  + "%";
        }
      }
    }
  }

  window.onload = (event) => {

      values = document.querySelectorAll(".myBar")
      values.forEach(function (v) {
          move(v)
          i=0;
      })
  }
</script>
