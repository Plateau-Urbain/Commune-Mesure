<script>

  var colors = ["rgb(61, 30, 109, 0.3)","rgb(243, 119, 53, 0.3)",
  "rgb(193, 4, 236, 0.3)","rgb(105, 210, 30, 0.3)", "rgb(76, 138, 136, 0.3)",
  "rgb(238, 64, 53, 0.3)","rgb(243, 119, 54, 0.3)", "rgb(253, 244, 152, 0.3)",
  "rgb(123, 192, 67, 0.3)","rgb(3, 146, 207, 0.3)",
  "rgb(209, 17, 65, 0.3)","rgb(126, 141, 152, 0.3)","rgb(41, 168, 171, 0.3)",
  "rgb(198, 134, 66, 0.3)","rgb(210, 231, 255, 0.3)","rgb(255, 87, 51, 0.3)",
  "rgb(128, 229, 226, 0.3)","rgb(147, 128, 229, 0.3)","rgb(70, 41, 199, 0.3)", ];

  function getRandomColor(){
    return colors[getRandomInt(colors.length,0)];
  }
  function getRandomInt(max, min) {
    return min+Math.floor(Math.random() * Math.floor(max));
  }
  function getRandomPointStyle(){
    var pointStyles = ['circle','cross','crossRot','dash','line','rect',
    'rectRounded','rectRot','star','triangle'];
    return pointStyles[getRandomInt(pointStyles.length,0)];
  }
  var datasetBubble = [];
  //TODO
  var complementTitle = "homme de +75ans";
  var yAxe = "";
  var xAxe = "";
  var assocAttrValuePop;
  var popBubbleChart;
  var dataPopFirst = {'name':null, 'position':1, 'data': null, 'id':null};
  var dataPopSecond = {'name':null, 'position':2, 'data': null, 'id':null};

  function getDataPopPlace(placeName, position){
    var dataPop = [];
    @foreach($places as $place)
      if("{{ $place->title }}" == placeName){

        if(position == 1){
          dataPopFirst.name = "{{ $place->name }}";
          let p = document.getElementById('title-left');
          let a = p.firstChild;
          a.setAttribute('href', "{{ route('place.show',['slug' => $place->title])  }}")
          a.textContent = "{{ $place->name }}";
        }else{
          let p = document.getElementById('title-right');
          let a = p.firstChild;
          a.setAttribute('href', "{{ route('place.show',['slug' => $place->title])  }}")
          a.textContent = "{{ $place->title }}";

          dataPopSecond.name = "{{ $place->name }}";
        }
        dataPop.push(
          @foreach ($place->data->population as $key => $value)
            {{ $value }},
          @endforeach
        );
        return dataPop;
      }

    @endforeach

  }

  function getLabelsPopPlace(){
    var labelPop = [];
    @foreach($places as $place)
      labelPop.push(
        @foreach ($place->data->population as $key => $value)
          "{{ $key }}",
        @endforeach
      );
      @break
    @endforeach
    return labelPop;
  }

  var mixedChart;
  function comparePopulationPlaces(select){
    if(mixedChart !== undefined){
      mixedChart.destroy();
      if(select.name == dataPopFirst.position){
        dataPopFirst.data = getDataPopPlace(select.value, dataPopFirst.position);
      }else{
        dataPopSecond.data = getDataPopPlace(select.value, dataPopSecond.position);
      }

    }


     mixedChart = new Chart(document.getElementById("chart-overlay-compare"), {
      type: 'bar',
      data: {
        datasets: [{
            label: dataPopFirst.name,
            data: dataPopFirst.data,
            borderColor: 'rgba(77, 171, 247, 1)',
            backgroundColor: 'rgba(77, 171, 247, 0.3)'
        }, {
          label: dataPopSecond.name,
          data: dataPopSecond.data,
          type: 'bar',
          backgroundColor: 'rgba(186, 200, 255, 0.3)',
          borderColor: 'rgba(186, 200, 255, 1)',
        }],
        labels: getLabelsPopPlace()
      }
      });
  }
  function populationAxesChart(axe, element){
    if(element != null){
      if(element.name == "xAxe"){
        xAxe = axe;
      }else{
        yAxe = axe;
      }
    }

    if(xAxe !== "" && yAxe !== ""){
      datasetBubble = [];
      @foreach($places as $place)
        @if($place->data->population->total !== null)
        assocAttrValuePop = {
          @foreach ($place->data->population as $key => $value)
            "{{ $key }}":{{ $value }},
          @endforeach
        };
          datasetBubble.push({
            label: ['{{ $place->name }}'],
            backgroundColor: getRandomColor(),
            borderColor: "rgba(255,221,50,1, 0.3)",
            pointStyle: 'circle',
            data: [{
              y: assocAttrValuePop[yAxe],
              x: assocAttrValuePop[xAxe],
              r: getRandomInt(20,10)
            }]
          });
        @endif
      @endforeach
      if(typeof popBubbleChart == 'undefined'){
        popBubbleChart = new Chart(document.getElementById("chart-bubble-pop"), {
          type: 'bubble',
          data: {
            labels: "Africa",
            datasets: datasetBubble
          },
          options: {
            title: {
              display: true,
              text: 'Population la tranche '+xAxe+' sur '+yAxe,
            }, scales: {
              yAxes: [{
                scaleLabel: {
                  display: true,
                  labelString: yAxe
                }
              }],
              xAxes: [{
                scaleLabel: {
                  display: true,
                  labelString: xAxe
                }
              }]
            }
          }
        });
      }else{
        popBubbleChart.data.datasets=datasetBubble;
        popBubbleChart.options = {
          title: {
            display: true,
            text: 'Population la tranche '+xAxe+' sur '+yAxe,
          }, scales: {
            yAxes: [{
              scaleLabel: {
                display: true,
                labelString: yAxe
              }
            }],
            xAxes: [{
              scaleLabel: {
                display: true,
                labelString: xAxe
              }
            }]
          }
        };
        popBubbleChart.update();
      }

    }
  }
</script>
