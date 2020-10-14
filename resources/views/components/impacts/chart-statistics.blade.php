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
      tooltip: {
          custom: function({series, seriesIndex, dataPointIndex, w}) {
            return '<div class="arrow_box" style="padding: 10px;">' +
              '<strong>' +  w.config.series[seriesIndex].name.replace('&#039;', "'") + '</strong> <ul><li>'+w.config.xaxis.title.text+' : '+w.config.series[seriesIndex].data[0][0]+'</li><li>'+w.config.yaxis[0].title.text+' : '+w.config.series[seriesIndex].data[0][1]+'</li></ul>' +
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

    statschart.updateOptions(
      {
        title: {
            text: 'Lieux en fonction du ' + rightTitle + " et du " + leftTitle
        },
        xaxis: {
            tickAmount: 12,
            tickPlacement: 'between',
            type: 'category',
            min: undefined,
            max: undefined,
            title: { text: leftTitle}

        },
        yaxis:{
          tickAmount: 10,
          tickPlacement: 'between',
          min:undefined,
          max: undefined,
          title: { text: rightTitle }
        }
      }
    );

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

        statschart.appendSeries({
            name: key,
            data: [[dataLeft, dataRight, 8]]
        });
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
