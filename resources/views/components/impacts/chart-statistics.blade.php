<script src="/js/apexcharts.min.js"></script>
<script>
    var leftTitle;
    var rightTitle;

    var template = document.querySelector("template#detail-chart");
    var options = {
      series: [{
        name: 'Légende',
        data: []
      }],
      chart: {
        toolbar:{
          show:false,
        },
        height: 450,
        width: "100%",
        type: 'scatter',
    },
      fill: {
          opacity: 1
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
          custom: function({series, seriesIndex, dataPointIndex, w}) {
            return '<div class="arrow_box" style="padding: 10px;">' +
              '<strong>' +  w.config.series[seriesIndex].name.replace('&#039;', "'") + '</strong> <ul><li>Superficie du lieu (m2) : 10</li><li>Nombre d\'évenement : 5</li></ul>' +
              '</div>'
          },
          onDatasetHover: {
              highlightDataSeries: false,
          }
        },
        dataLabels: {
          enabled: true,
          textAnchor: 'start',
          offsetX: 6,
          formatter: function(value, { seriesIndex, dataPointIndex, w }) {
              var name = w.config.series[seriesIndex].name.replace('&#039;', "'");
              if(name.length > 10) {
                  name = name.substr(0,10)+"...";
              }
              return name;
          },
          style: {
              colors: undefined
          },
          background: {
              enabled: false
          }

        },
      xaxis: {
          tickAmount: 12,
          type: 'category',
          min: undefined,
          max: undefined

      },
      yaxis:{
        tickAmount: 10,
        min:undefined,
        max: undefined
      },
      legend: {
        show:false,
      }
    };
    var maxX = 0, maxY = 0, minX=9999999, minY=9999999;
    function getMaxXaxis(dataX){
      if(maxX < dataX)
        maxX = dataX + dataX/2;
      return maxX;
    }

    function getMaxYaxis(dataY){
      if(maxY < dataY)
        maxY = dataY + dataY/2;
      return maxY;
    }

    function getMinXaxis(dataX){
      if(minX > dataX && dataX > 10)
        minX = - dataX;
      return minX;
    }

    function getMinYaxis(dataY){
      if(minY > dataY && dataY > 10)
        minY = - dataY;
      return minY;
    }
   var statschart = new ApexCharts(document.querySelector("#stats-chart"), options);
   statschart.render();
  var compares = JSON.parse("{{ json_encode($compares) }}".replace(/&quot;/g,'"'));
  var LeftIndicator ;
  var RightIndicator;
  var dataLeft,dataRight;

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

    leftTitle = selectcmpL.options[selectcmpL.selectedIndex].text;
    rightTitle = selectcmpR.options[selectcmpR.selectedIndex].text;

    LeftIndicator = selectcmpL.value;
    RightIndicator = selectcmpR.value;

    if(leftTitle == rightTitle){
      alert("Vos indicateurs sont identiques.");
      return;
    }
    if (leftTitle == "" && rightTitle == "") {
      document.getElementById("titleCmpLeft").innerHTML = leftTitle;
      document.getElementById("titleCmpRight").innerHTML = rightTitle;
    }

    for (const [key, value] of Object.entries(compares.data)) {
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
      /*statschart.updateOptions(
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
    );*/

        if(dataLeft && dataRight) {
            console.log(key+":"+dataLeft+","+dataRight);
            statschart.appendSeries({
                name: key,
                data: [[dataLeft, dataRight, 10]]
            });
        }


    }
    LeftIndicator = traduction(LeftIndicator)
    RightIndicator = traduction(RightIndicator)


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
