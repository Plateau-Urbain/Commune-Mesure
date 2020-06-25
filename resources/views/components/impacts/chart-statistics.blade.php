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
  window.onload= function(){
    yAxe = xAxe = "total";
    populationAxesChart(null, null);
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
