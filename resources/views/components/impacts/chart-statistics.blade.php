<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var places = [];

    var options = {
      series: [{
        name: 'Légende',
        data: []
      }],
      chart: {
        toolbar:{
          show:false,
        },
        height: 550,
        width: "100%",
        type: 'bubble',
        events: {
          dataPointSelection: function(event, chartContext, config) {
            var selectedName = config.w.config.series[config.seriesIndex].name
          },
          dataPointMouseEnter: function(event, chartContext, config) {
            var circle = event.target
            colorGet = circle.getAttribute('fill')
            var selectedName = config.w.config.series[config.seriesIndex].name
            list_el = document.getElementById('list_'+selectedName)
            list_el.style.color = colorGet
            setTimeout(function() { list_el.style.color = ""; }, 400);
          }
        }
      },
      dataLabels: {
          enabled: false
      },
      fill: {
          opacity: 0.8
      },
      title: {
          text: "Rapport",
          style: {
            fontSize:  '13px',
            fontWeight:  'bold',
            color:  '#616161'
          },
      },
      tooltip: {
        x:{
           show: false,
        },
        y: {
          formatter: function (val) {
            return val
          }
        }
      },
      xaxis: {
          tickAmount: 10,
          type: 'category',
          min: -20,
          max: 300

      },
      yaxis:{
        tickAmount: 10,
        min:-2,
        max: 20
      },
      legend: {
        show:false,
      }
    };
    var maxX = 0, maxY = 0, minX=9999999, minY=9999999;
    function getMaxXaxis(dataX){
      console.log(dataX)
      if(maxX < dataX)
        maxX = dataX + dataX/2;
      return maxX;
    }

    function getMaxYaxis(dataY){
      console.log(dataY)
      if(maxY < dataY)
        maxY = dataY + dataY/2;
      return maxY;
    }

    function getMinXaxis(dataX){
      console.log(dataX)
      if(minX > dataX && dataX > 10)
        minX = - dataX;
      return minX;
    }

    function getMinYaxis(dataY){
      console.log(dataY)
      if(minY > dataY && dataY > 10)
        minY = - dataY;
      return minY;
    }
   var statschart = new ApexCharts(document.querySelector("#stats-chart"), options);
   statschart.render();

  var compares = JSON.parse("{{ json_encode($compares) }}".replace(/&quot;/g,'"'));
  var places_name = JSON.parse("{{ json_encode($compares) }}".replace(/&quot;/g,'"'));
  var LeftIndicator ;
  var RightIndicator;
  var dataLeft,dataRight;

  var placesLValues = document.querySelectorAll('.leftPlaceIndicator');
  var placesRValues = document.querySelectorAll('.rightPlaceIndicator');
  var title = document.querySelector('.apexcharts-title-text')
  function cleanStatsChart(){
    statschart.updateSeries([
      {
        name: '',
        data: [[,,]]
      },
    ]);

  }
  function comparePlacePoints(selectcmpL, selectcmpR){
    // options.xaxis.max = 350;
    minX=9999999, minY=9999999
    maxX = 0, maxY = 0;
    cleanStatsChart()

    var tabRightValues = [];
    var tabLeftValues = [];

    var leftTitle = selectcmpL.options[selectcmpL.selectedIndex].text;
    var rightTitle = selectcmpR.options[selectcmpR.selectedIndex].text;
    // title.innerHTML = "Rapport entre " + leftTitle + " et " + rightTitle + " par an";

    LeftIndicator = selectcmpL.value;
    RightIndicator = selectcmpR.value;


    if(leftTitle == '--' || rightTitle == "--"){
      console.log(selectcmpL);
      console.log(selectcmpR);
    }
    if(leftTitle == rightTitle){
      alert("Vos indicateurs sont identiques.");
      return;
    }
    if (leftTitle == "" && rightTitle == "") {
      document.getElementById("titleCmpLeft").innerHTML = leftTitle;
      document.getElementById("titleCmpRight").innerHTML = rightTitle;
    }

    for (const [key, value] of Object.entries(compares.data)) {
      // console.log(`${key}: ${value.moyens.etp.nombre}`);
      if (value.realisations[LeftIndicator] == undefined) {
          dataLeft = value.moyens[LeftIndicator].nombre;
      }
      else {
        dataLeft = value.realisations[LeftIndicator].nombre;
      }
      if (value.moyens[RightIndicator] == undefined) {
          dataRight = value.realisations[RightIndicator].nombre;
      }
      else {
        dataRight = value.moyens[RightIndicator].nombre;

      }
      statschart.updateOptions(
        {
          xaxis: {
            max:getMaxXaxis(dataLeft),
            min: getMinXaxis(dataLeft),
            tickAmount: 12,
            type: 'category',
          },
          yaxis:{
            max:getMaxYaxis(dataRight),
            min: getMinYaxis(dataRight),
            tickAmount: 10,
          }
        }
      );
      statschart.appendSeries({
         name: key,
         data: [[dataLeft, dataRight, 10]]
       });
       // statschart.options

       places.push(key);
       tabLeftValues.push(dataLeft);
       tabRightValues.push(dataRight);
       for (var i = 0; i < tabLeftValues.length; i++) {
         placesLValues[i].innerHTML = tabLeftValues[i]
       }

       for (var j = 0; j < tabRightValues.length; j++) {
         placesRValues[j].innerHTML = tabRightValues[j]
       }


    }
    LeftIndicator = traduction(LeftIndicator)
    RightIndicator = traduction(RightIndicator)

    document.getElementById("stats_selectedLeftValue").innerHTML = LeftIndicator.toUpperCase()
    document.getElementById("stats_selectedRightValue").innerHTML = RightIndicator.toUpperCase()

  }

  function selectAll(source){
    checkboxes = document.querySelectorAll(".checkPlaces")
    checkboxes.forEach(function(element){
      element.checked = source.checked;
    });
  }
  function traduction(expression) {
    switch (expression) {
      case 'event':
        expression = 'nombre d\'évènements'
        break;
      case 'benevole':
        expression = 'nombre de bénévoles'
        break;
      case 'ouverture':
        expression = 'heures d\'ouvertures'
        break;
      case 'struct_hebergee':
        expression = 'nombre de structures'
        break;
      case 'partenaire':
        expression = 'nombre de partenaires'
        break;
    }
    return expression
  }
</script>
