<script>
  var i = 0;
  var values;

  function move(element) {
    var width = 10;
    if (i == 0) {
      i = 1;
      var elem = element;
      var id = setInterval(frame, 30);
      var fill = parseInt(element.dataset.fill);
      var full = parseInt(element.dataset.full);
      var widthfill = fill;
      element.setAttribute("data-tooltip", widthfill+"%")
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

  var colors = ["#ee4035", "#f37736", "#fdf498", "#7bc043", "#0392cf",
  "#d11141", "#f37735", "#7e8d98", "#29a8ab", "#3d1e6d", "#c68642", "#d2e7ff"];

    var smallmap = mapjs.create('info-box-map')
    L.marker([{{ $place->geo->lat }}, {{ $place->geo->lon}}]).addTo(smallmap)
    smallmap.setView([{{ $place->geo->lat }}, {{ $place->geo->lon}}], 9)

    //TODO if we wont use chart on place page delete next code
    // @foreach($plots as $plot)
    //   var chartPop = new charts.create(
    //       '{{ $plot->getId() }}',
    //       '{{ $plot->getType() }}',
    //       @json($plot->getLabels()),
    //       @json($plot->getDatasets())
    //   );
    // @endforeach

function animateBar(){
  elements = document.querySelectorAll(".myBar")
  elements.forEach(function (element) {
      move(element)
      i=0;
  })
}

  window.onload = (event) => {//TODO move in index.js
    animateBar();

  }
</script>
