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

var datajson = {
  "nodes": [
    {
      "id": "n0",
      "label": "A node",
      "x": 0,
      "y": 0,
      "size": 3
    },
    {
      "id": "n1",
      "label": "Another node",
      "x": 3,
      "y": 1,
      "size": 2
    },
    {
      "id": "n2",
      "label": "And a last one",
      "x": 1,
      "y": 3,
      "size": 1
    }
  ],
  "edges": [
    {
      "id": "e0",
      "source": "n0",
      "target": "n1"
    },
    {
      "id": "e1",
      "source": "n1",
      "target": "n2"
    },
    {
      "id": "e2",
      "source": "n2",
      "target": "n0"
    }
  ]
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
    { id: "n0", label: "A node", x: 0, y: 0, size: 3, color: '#008cc2' },
    { id: "n1", label: "Another node", x: 3, y: 1, size: 2, color: '#008cc2' },
    { id: "n2", label: "And a last one", x: 1, y: 3, size: 1, color: '#E57821' }
  ],
  edges: [
    { id: "e0", source: "n0", target: "n1", color: '#282c34', type:'curve', size:0.5 },
    { id: "e1", source: "n1", target: "n2", color: '#282c34', type:'curve', size:1},
    { id: "e2", source: "n2", target: "n0", color: '#FF0000', type:'curve', size:2}
  ]
}

// Load the graph in sigma
s.graph.read(graph);
// Ask sigma to draw it
s.refresh();


  window.onload = (event) => {//TODO move in index.js
    setCaptionDataBar(placeData.insee.iris, "iris");

    animateBar();



  }
</script>
