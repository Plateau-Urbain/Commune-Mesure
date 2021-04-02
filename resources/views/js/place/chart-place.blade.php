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

      if(widthfill != 0){
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
  }

  var colors = ["#F1F1F1", "#E85048", "#fdf498", "#7bc043", "#0392cf",
  "#d11141", "#f37735", "#7e8d98", "#29a8ab", "#3d1e6d", "#c68642", "#d2e7ff"];

  @if($place->getVisibilitybySection('accessibilite') && !isset($edit) || isset($edit))

      var smallmap = mapjs.create('info-box-map')
    L.marker([{{ $place->get('blocs->data_territoire->donnees->geo->lat') }}, {{ $place->get('blocs->data_territoire->donnees->geo->lon') }}]).addTo(smallmap)
      smallmap.setView([{{ $place->get('blocs->data_territoire->donnees->geo->lat') }}, {{ $place->get('blocs->data_territoire->donnees->geo->lon') }}], 9)
  @endif
function animateBar(){
  elements = document.querySelectorAll(".myBar")
  elements.forEach(function (element) {
      move(element)
      i=0;
  })
}

function setCaptionDataBar(currentDataZone, zone){
  // console.log(currentDataZone)
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
  // console.log(totalActif)
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
var select_zone;
function setInseeChartData(currentDataZone,zone){
  select_zone = zone;
  var data = @json($place->get('blocs->data_territoire->donnees->insee'));
  var dataIris = data["iris"].activites
  var dataRegion = data["region"].activites
  var dataCommune = data["commune"].activites
  var dataDepartement = data["departement"].activites

  var totalActif = 0;
  var totalCsp = 0;
  var totalLogement = 0;

  Object.values(currentDataZone.activites).forEach(function(val){
    totalActif += val.nb;
  });
  Object.values(currentDataZone.logement).forEach(function(val){
    totalLogement += val.nb;
    // console.log(totalLogement);

  });
  Object.values(currentDataZone.csp).forEach(function(val){
    totalCsp += val.nb;
  });

  // console.log(tabActifTitle)
  // console.log(tabActifData)

    // let data = Object.entries(currentDataZone.activites)[i][1];
    // let percent = data.nb * 100 / totalActif;

    actifChart.updateSeries([
      {
        name: data[zone].activites[0].title,
        data: [63.70, data[zone].activites[0].nb * 100/totalActif ]
      },
      {
        name: data[zone].activites[1].title,
        data: [8.70, data[zone].activites[1].nb * 100/totalActif ]
      },
      {
        name: data[zone].activites[2].title,
        data: [10.30, data[zone].activites[2].nb * 100/totalActif ]
      },
      {
        name: data[zone].activites[3].title,
        data: [6.7, data[zone].activites[3].nb * 100/totalActif ]
      },
      {
        name: data[zone].activites[4].title,
        data: [10.60, data[zone].activites[4].nb * 100/totalActif ]
      },
    ]);
    immobilierChart.updateSeries([
      {
        name: data[zone].logement[0].title,
        data: [0, data[zone].logement[0].nb * 100 / totalLogement]
      },
      {
        name: data[zone].logement[1].title,
        data: [43.71, data[zone].logement[1].nb * 100 / totalLogement]
      },
      {
        name: data[zone].logement[2].title,
        data: [56.29, data[zone].logement[2].nb * 100 / totalLogement]
      },
    ]);
    cspChart.updateSeries([
      {
        name: data[zone].csp[0].title,
        data: [0, data[zone].csp[0].nb * 100 / totalCsp]
      },
      {
        name: data[zone].csp[1].title,
        data: [1.36, data[zone].csp[1].nb * 100 / totalCsp]
      },
      {
        name: data[zone].csp[2].title,
        data: [6.12, data[zone].csp[2].nb * 100 / totalCsp]
      },
      {
        name: data[zone].csp[3].title,
        data: [16.54, data[zone].csp[3].nb * 100 / totalCsp]
      },
      {
        name: data[zone].csp[4].title,
        data: [28.94, data[zone].csp[4].nb * 100 / totalCsp]
      },
      {
        name: data[zone].csp[5].title,
        data: [21.83, data[zone].csp[5].nb * 100 / totalCsp]
      },
      {
        name: data[zone].csp[6].title,
        data: [25.21, data[zone].csp[6].nb * 100 / totalCsp]
      },
      {
        name: data[zone].csp[7].title,
        data: [0, data[zone].csp[7].nb * 100 / totalCsp]
      },
    ]);
}

  // function updateBar(currentDataZone, zone){
  //   var totalActif = 0;
  //   var totalCsp = 0;
  //   var totalLogement = 0;
  //   Object.values(currentDataZone.activites).forEach(function(val){
  //     totalActif += val.nb;
  //   });
  //   Object.values(currentDataZone.logement).forEach(function(val){
  //     totalLogement += val.nb;
  //   });
  //   Object.values(currentDataZone.csp).forEach(function(val){
  //     totalCsp += val.nb;
  //   });
  //   for (var i = 0; i < 5; i++) {
  //     let data = Object.entries(currentDataZone.activites)[i][1];
  //     let percent = data.nb * 100 / totalActif;
  //     actifChart.appendSeries({
  //       name: data.title,
  //       data: [percent.toFixed(1)]
  //     });
  //   }
  //   for (var j = 0; j < 8; j++) {
  //     let data = Object.entries(currentDataZone.csp)[j][1];
  //     let percent = data.nb * 100 / totalCsp;
  //     categoryChart.appendSeries({
  //       name: data.title,
  //       data: [percent.toFixed(1)]
  //     });
  //   }
  //   for (var k = 0; k < 3; k++) {
  //     let data = Object.entries(currentDataZone.logement)[k][1];
  //     let percent = data.nb * 100 / totalLogement;
  //     immobilierChart.appendSeries({
  //       name: data.title,
  //       data: [percent.toFixed(1)]
  //     });
  //   }
  // }


  window.onload = (event) => {//TODO move in index.js
    setCaptionDataBar(placeData.insee.iris, "iris");
    setInseeChartData(placeData.insee.iris,"iris")
    animateBar();

  }

</script>
