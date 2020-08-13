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


var s = new sigma(
  {
    renderer: {
      container: document.getElementById('sigma'),
      type: 'canvas'
    },
    settings: {
     minEdgeSize: 0.1,
     maxEdgeSize: 2,
     minNodeSize: 1,
     maxNodeSize: 8,
    }
  }
);

// Create a graph object
var graph = {
  nodes: [
    { id: "0", label: "Bien-être", x: 0, y: 0, size: 3, color: '#008cc2' },
    { id: "1", label: "Environnement et dévelop. durable", x: 2, y: 1, size: 3, color: '#008cc2' },
    { id: "2", label: "Solidarité", x: 2.5, y: 3, size: 3, color: '#008cc2' },
    { id: "3", label: "Éducation", x: -2, y: 3, size: 3, color: '#008cc2' },
    { id: "4", label: "Art et création", x: -4, y: 3, size: 3, color: '#008cc2' },
    { id: "5", label: "Activités", x: -6, y: 3, size: 3, color: '#008cc2' },

    { id: "6", label: "Écoute", x: 1.5, y: 1, size: 3, color: '#008cc2' },
    { id: "7", label: "citoyenneté", x: 3, y: 1, size: 3, color: '#008cc2' },
    { id: "8", label: "vivre ensemble", x: -2, y: 2, size: 3, color: '#008cc2' },
    { id: "9", label: "transmission", x: -2, y: 1.5, size: 3, color: '#008cc2' },
    { id: "10", label: "laïcité", x: -0.5, y: 3, size: 3, color: '#008cc2' },
    { id: "11", label: "formation des individus", x: -2, y: 3, size: 3, color: '#008cc2' },
    { id: "12", label: "innovation économique", x: -2, y: 3, size: 3, color: '#008cc2' },
    { id: "13", label: "innovation sociale", x: -1, y: 0, size: 3, color: '#008cc2' },
  ],
  edges: [
    { id: "0", source: "0", target: "8", color: '#FF0000', type:'curve', size:1},
    { id: "1", source: "1", target: "12", color: '#FF0000', type:'curve', size:1},
    { id: "2", source: "1", target: "13", color: '#FF0000', type:'curve', size:1},
    { id: "3", source: "0", target: "10", color: '#FF0000', type:'curve', size:1},
    { id: "4", source: "3", target: "11", color: '#FF0000', type:'curve', size:1},
    { id: "5", source: "1", target: "2", color: '#FF0000', type:'curve', size:1},
    { id: "6", source: "2", target: "6", color: '#008cc2', type:'curve', size:1},
    { id: "7", source: "2", target: "10", color: '#008cc2', type:'curve', size:1},
    { id: "8", source: "2", target: "8", color: '#008cc2', type:'curve', size:1}
  ]
}

// Load the graph in sigma
s.graph.read(graph);
// Ask sigma to draw it
s.refresh();





d3.select("#sigma").append("svg")
        .attr("class", "svg")
        .attr("width", width)
        .attr("height", height)
        .append("g") // Ajout du groupe qui contiendra tout les mots
            .attr("transform", "translate(" + width / 2 + ", " + height / 2 + ")") // Centrage du groupe
            .selectAll("text")
            .data(myWords)
            .enter().append("text") // Ajout de chaque mot avec ses propriétés
                .style("font-size", d => d.size + "px")
                .style("font-family", fontFamily)
                .style("fill", d => fillScale(d.size))
                .attr("text-anchor", "middle")
                // .attr("transform", d => "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")")
                .text(d => d.text);


  window.onload = (event) => {//TODO move in index.js
    setCaptionDataBar(placeData.insee.iris, "iris");

    animateBar();

    if(document.readyState === "complete"){
      const width = document.getElementById("sigma").offsetWidth * 0.95,
          height = 500,
          fontFamily = "Open Sans",
          fontScale = d3.scaleLinear().range([20, 120]), // Construction d'une échelle linéaire continue qui va d'une font de 20px à 120px
          fillScale = d3.scaleOrdinal(d3.schemeCategory10);
          var myWords = [{word: "Running", size: "10"}, {word: "Surfing", size: "20"}, {word: "Climbing", size: "50"}, {word: "Kiting", size: "30"}, {word: "Sailing", size: "20"}, {word: "Snowboarding", size: "60"} ]

          // List of words
          var myWords = [{word: "Running", size: "10"}, {word: "Surfing", size: "20"}, {word: "Climbing", size: "50"}, {word: "Kiting", size: "30"}, {word: "Sailing", size: "20"}, {word: "Snowboarding", size: "60"} ]

          // set the dimensions and margins of the graph
          var margin = {top: 10, right: 10, bottom: 10, left: 10},

    }
</script>
