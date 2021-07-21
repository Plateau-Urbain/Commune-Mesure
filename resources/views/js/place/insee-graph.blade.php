<script>
  @if($place->getVisibilitybySection('accessibilite') && !isset($edit) || isset($edit))
    var placeLatLon = {
        'lat': {{ $place->get('blocs->data_territoire->donnees->geo->lat') }},
        'lon': {{ $place->get('blocs->data_territoire->donnees->geo->lon') }}
    }
  @endif

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
  });
  Object.values(currentDataZone.csp).forEach(function(val){
    totalCsp += val.nb;
  });

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

// Génération des graphs
var options = {
    colors:[],
    title:{
      text:''
    },
    series: [{
        name: '',
        data: [0]
      }],
    chart: {
        type: 'bar',
        height: 175,
        stacked: true,
        stackType: '100%',
        toolbar:{
            show:false,
          },
      },
    plotOptions: {
        bar: {
            horizontal: true,
          },
      },
    stroke: {
        width: 1,
        colors: ['#fff']
      },
    grid: {
        show:false,
      },
    annotations: {
      },
    xaxis: {
        show:false,
        categories:['Niveau national','Niveau '+document.getElementById("selectGeo").value],
        axisBorder:{
            show:false,
          },
        axisTicks: {
            show: false,
          },
        labels:{
            show:false,
          }
      },
    tooltip: {
  x: { formatter: function (val) { if (val == "Niveau national") return "Niveau national"; return "Niveau "+select_zone;}},
        y: {
            formatter: function (val) {
                return val.toFixed(2) + "%"
              }
          }
      },
    fill: {
        opacity: 1

      },
    legend: {
        show:true,
        position: 'bottom',
        horizontalAlign: 'right',
        showForZeroSeries: false,
      }
  };

  options.colors = ['#F05F3B','#f07d60','#A5C5C3', '#429F9E', '#007872']
  options.title.text = 'Population'
  var actifChart = new ApexCharts(document.querySelector("#actifsChart"), options);

  options.colors = ['#bf607e', '#ca4a3d', '#e3a7a1','#fcd2bb','#c7dfec','#81b8d6','#3680b6','#1b519c']
  options.title.text = 'Catégories socioprofessionnelles'
  var cspChart = new ApexCharts(document.querySelector("#cateChart"), options);

  options.colors = ['#E1E1E1', '#456EB8', '#F3771B']
  options.title.text = 'Immobilier'
  var immobilierChart = new ApexCharts(document.querySelector("#immoChart"), options);



</script>
