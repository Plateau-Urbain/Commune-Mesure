<script>
  var i = 0;
  var values;

  function move(element) {
    var width = 0;
    if (i == 0) {
      i = 1;
      var elem = element;
      var id = setInterval(frame, 30);
      var fill = parseInt(element.dataset.fill);
      var full = parseInt(element.dataset.full);
      var widthfill = fill;
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

function setCaptionDataBar(currentDataZone, zone){

  var totalActif = 0;
  var totalCsp = 0;
  var totalLogement = 0;
  Object.values(placeData.insee.iris.activites).forEach(function(val){
    totalActif += val.nb;
  });
  Object.values(placeData.insee.iris.logement).forEach(function(val){
    totalLogement += val.nb;
  });
  Object.values(placeData.insee.iris.csp).forEach(function(val){
    totalCsp += val.nb;
  });
  var actifBarElements = document.querySelectorAll(".actifBar")
  var actifCaption = document.querySelectorAll(".actifCaption")
  var actifTitle = document.querySelectorAll(".actifTitle")
  actifBarElements.forEach(function (element, i) {
    let data = Object.entries(placeData.insee.iris.activites)[i][1];
    let percent = data.nb * 100 / totalActif;
    element.setAttribute("data-tooltip", data.title+":"+percent.toFixed(2)+"%");
    element.setAttribute("data-fill", percent);
    actifCaption[i].style.backgroundColor = element.style.backgroundColor;
    actifTitle[i].innerHTML = data.title;
  })
  var cspBarElements = document.querySelectorAll(".cspBar")
  var cspCaption = document.querySelectorAll(".cspCaption")
  var cspTitle = document.querySelectorAll(".cspTitle")
  cspBarElements.forEach(function (element, i) {
    let data = Object.entries(placeData.insee.iris.csp)[i][1];
     let percent = data.nb * 100 / totalCsp
    element.setAttribute("data-tooltip", data.title+":"+percent.toFixed(2)+"%");
    element.setAttribute("data-fill", percent);
    cspCaption[i].style.backgroundColor = element.style.backgroundColor;
    cspTitle[i].innerHTML = data.title;
  })
  var logementBarElements = document.querySelectorAll(".logementBar")
  var logementCaption = document.querySelectorAll(".logementCaption")
  var logementTitle = document.querySelectorAll(".logementTitle")
  logementBarElements.forEach(function (element, i) {
    let data = Object.entries(placeData.insee.iris.logement)[i][1];
    let percent = data.nb * 100 / totalLogement;
    element.setAttribute("data-tooltip", data.title+":"+percent.toFixed(2)+"%");
    element.setAttribute("data-fill", percent);
    logementCaption[i].style.backgroundColor = element.style.backgroundColor;
    logementTitle[i].innerHTML = data.title;
  })
}

  window.onload = (event) => {//TODO move in index.js
    setCaptionDataBar(placeData.insee.iris, "iris");

    animateBar();

  }
</script>
