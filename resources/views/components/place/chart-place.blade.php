<script>

  var i = 0;
  var values;

  function move(element) {
    var width = Number.parseFloat(element.getAttribute("data-prec"));

    if (i == 0) {
      i = 1;
      var elem = element;

      var fill = parseInt(element.dataset.fill);
      var full = parseInt(element.dataset.full);
      var widthfill = fill;
      var stop = false;
      var id;
      if(width >= widthfill){
        id = setInterval(frameDown, 5);
        function frameDown() {
          if (stop) {
            clearInterval(id);
            i = 0;
          } else {
            if(width <= widthfill){
              stop = true;
            }
            width = width - 0.1;
            elem.style.width = width + "%";
            elem.innerHTML = width.toFixed(0)  + "%";
          }
        }
      }else{
        id = setInterval(frameUp, 5);
        function frameUp() {
          if (stop) {
            clearInterval(id);
            i = 0;
          } else {
            if(width >= widthfill){
              stop = true;
            }
            width = (width + 0.1);
            elem.style.width = width + "%";
            elem.innerHTML = width.toFixed(0)  + "%";
          }
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
  Object.values(currentDataZone.activites).forEach(function(val){
    totalActif += val.nb;
  });
  Object.values(currentDataZone.logement).forEach(function(val){
    totalLogement += val.nb;
  });
  Object.values(currentDataZone.csp).forEach(function(val){
    totalCsp += val.nb;
  });
  console.log(totalActif)
  var actifBarElements = document.querySelectorAll(".actifBar")
  var actifCaption = document.querySelectorAll(".actifCaption")
  var actifTitle = document.querySelectorAll(".actifTitle")
  actifBarElements.forEach(function (element, i) {
    let data = Object.entries(currentDataZone.activites)[i][1];
    let percent = data.nb * 100 / totalActif;
    element.setAttribute("data-tooltip", data.title+":"+percent.toFixed(0)+"%");
    let fill = element.getAttribute("data-fill");
    if(fill !== null){
      element.setAttribute("data-prec", fill);
    }else{
      element.setAttribute("data-prec", "0");
    }
    element.setAttribute("data-fill", percent.toFixed(1));
    actifCaption[i].style.backgroundColor = element.style.backgroundColor;
    actifTitle[i].innerHTML = data.title;
  })
  var cspBarElements = document.querySelectorAll(".cspBar")
  var cspCaption = document.querySelectorAll(".cspCaption")
  var cspTitle = document.querySelectorAll(".cspTitle")
  cspBarElements.forEach(function (element, i) {
    let data = Object.entries(currentDataZone.csp)[i][1];
     let percent = data.nb * 100 / totalCsp
    element.setAttribute("data-tooltip", data.title+":"+percent.toFixed(0)+"%");
    let fill = element.getAttribute("data-fill");
    if(fill !== null){
      element.setAttribute("data-prec", fill);
    }else{
      element.setAttribute("data-prec", "0");
    }
    element.setAttribute("data-fill", percent.toFixed(1));

    cspCaption[i].style.backgroundColor = element.style.backgroundColor;
    cspTitle[i].innerHTML = data.title;
  })
  var logementBarElements = document.querySelectorAll(".logementBar")
  var logementCaption = document.querySelectorAll(".logementCaption")
  var logementTitle = document.querySelectorAll(".logementTitle")
  logementBarElements.forEach(function (element, i) {
    let data = Object.entries(currentDataZone.logement)[i][1];
    let percent = data.nb * 100 / totalLogement;
    element.setAttribute("data-tooltip", data.title+":"+percent.toFixed(0)+"%");
    let fill = element.getAttribute("data-fill");
    if(fill !== null){
      element.setAttribute("data-prec", fill);
    }else{
      element.setAttribute("data-prec", "0");
    }
    element.setAttribute("data-fill", percent.toFixed(1));
    logementCaption[i].style.backgroundColor = element.style.backgroundColor;
    logementTitle[i].innerHTML = data.title;
  })
}


  window.onload = (event) => {//TODO move in index.js
    setCaptionDataBar(placeData.insee.iris, "iris");

    animateBar();
  }
</script>
