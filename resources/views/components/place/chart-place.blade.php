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
  var dataIris = {x : [5,9,2,6,4,3.5,4.5,3.2,4.8],
  y : [3.5,3.2,0.3,3.6,3.9,3.4,2.9,4.9,9.6],
  "petal_length" : [1.2,1.3,1.5,1.5,0.3,0.5,1.9,1.4,1.1],
  "petal_width" : [0.2,0.2,0.2,0.2,0.2,0.2,0.2,0.2,0.2,0.4,0.3,0.1],
  "species" : ["setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa"]};

  var colors = ["#ee4035", "#f37736", "#fdf498", "#7bc043", "#0392cf",
  "#d11141", "#f37735", "#7e8d98", "#29a8ab", "#3d1e6d", "#c68642", "#d2e7ff"];
    var smallmap = mapjs.create('info-box-map')
    L.marker([{{ $place->geo->lat }}, {{ $place->geo->lon}}]).addTo(smallmap)
    smallmap.setView([{{ $place->geo->lat }}, {{ $place->geo->lon}}], 9)

    @foreach($plots as $plot)
      var chartPop = new charts.create(
          '{{ $plot->getId() }}',
          '{{ $plot->getType() }}',
          @json($plot->getLabels()),
          @json($plot->getDatasets())
      );
    @endforeach
    var dataLogement = [];
    var labelsLogement = [];
    @foreach($place->data->logement as $label => $data)
            dataLogement.push({{ $data }});
            labelsLogement.push('{{ $label }}');
    @endforeach

    var dataPopulation = [];
    var labelsPopulation = [];
    @foreach($place->data->population as $label => $data)
        dataPopulation.push({{ $data }});
        labelsPopulation.push('{{ $label }}');
    @endforeach
  // create Donut chart using defined data & customize plot options
  new roughViz.Donut(
  {
  element: '#chart-rough-logement-barh',
  data: {
   labels: labelsLogement,
   values: dataLogement
  },
  title: "Logements",
  roughness: 3,
  colors: colors,
  stroke: 'black',
  strokeWidth: 3,
  fillStyle: 'cross-hatch',
  fillWeight: 3.5,
  }
  );

  new roughViz.BarH(
  {
  element: '#chart-rough-logement-doughnut',
  data: {
   labels: labelsLogement,
   values: dataLogement
  },
  title: "Logements",
  roughness: 3,
  colors: colors,
  stroke: 'black',
  strokeWidth: 1,
  fillStyle: 'zigzag-line',
  fillWeight: 3.5,
  }
  );
  new roughViz.Scatter(
  {
    element: '#chart-rough-logement-scatter',
    data: dataIris,
    title: 'Les logements',
    colorVar: 'species',
    highlightLabel: 'species',
    fillWeight: 4,
    radius: 12,
    colors: colors,
    stroke: 'black',
    strokeWidth: 0.4,
    roughness: 0.6,
    width: window.innerWidth*0.7,
    font: 0,
    xLabel: 'sepal width',
    yLabel: 'petal length',
    curbZero: false,
  });
  window.onload = (event) => {

      values = document.querySelectorAll(".myBar")
      values.forEach(function (v) {
          move(v)
          i=0;
      })
  }
</script>
