<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var title = "Rapport entre" + + " et "+ "par an"
    var size = Math.floor(Math.random() * (200 - 100 + 1) + 100);

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
        type: 'bubble',
        events: {
          dataPointSelection: function(event, chartContext, config) {
            var selectedName = config.w.config.series[config.seriesIndex].name
            for (var i = 0; i < listed_places.length; i++) { if (listed_places[i] == selectedName) {  } }
          },
          dataPointMouseEnter: function(event, chartContext, config) {
            var selectedName = config.w.config.series[config.seriesIndex].name
            for (var i = 0; i < listed_places.length; i++) { if (listed_places[i] == selectedName) {  } }
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
          text: 'Rapport entre le nombre ETP et le nombre des Évènements par an',
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
          min:0,
          max:20,
          tickAmount: 12,
          type: 'category',
      },
      yaxis: {
          min:-10,
          max:300,
      },
      legend: {
        show:false,
      }
    };
   var statschart = new ApexCharts(document.querySelector("#stats-chart"), options);
   statschart.render();

  var compares = JSON.parse("{{ json_encode($compares) }}".replace(/&quot;/g,'"'));
  var places_name = JSON.parse("{{ json_encode($compares) }}".replace(/&quot;/g,'"'));

  function comparePlacePoints(selectcmpL, selectcmpR){

    var leftTitle = selectcmpL.options[selectcmpL.selectedIndex].text;
    var rightTitle = selectcmpR.options[selectcmpR.selectedIndex].text;

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
  }

  var ordonnee = [], abscisse = [];

  for (const [key, value] of Object.entries(compares.data)) {
    // console.log(`${key}: ${value.moyens.etp.nombre}`);
    // ordonnee.push(value.moyens.etp.nombre);
    // abscisse.push(value.realisations.event.nombre);
    statschart.appendSeries({
       name: key,
       data: [[value.moyens.etp.nombre, value.realisations.event.nombre, 10]]
     });
  }

var trace1 = {
  type: 'scatter',
  x: abscisse,
  y: ordonnee,
  mode: 'markers',
  name: 'Rapport entre le nombre ETP et le nombre des Évènements par an',
  text: Object.keys(compares.data),
  marker: {
    color: 'rgba(156, 165, 196, 0.95)',
    line: {
      color: '#FFF',
      width: 10,
    },
    symbol: 'circle',
    size: 16
  }
};
var data = [trace1];

var layout = {
  title: 'Nombre des ETP sur nombre d\'événements public et privé',
  xaxis: {
    showgrid: false,
    showline: true,
    linecolor: 'rgb(102, 102, 102)',
    title:'X : Par évènement',
    titlefont: {
      font: {
        color: 'rgb(204, 04, 204)'
      }
    },
    tickfont: {
      font: {
        color: 'rgb(102, 102, 102)'
      }
    },
    autotick: false,
    dtick: 10,
    ticks: 'outside',
    tickcolor: '#fe7651'
  },
  yaxis: {
    title:'Y : Par ETP',
    titlefont: {
      font: {
        color: 'rgb(204, 04, 204)'
      }
    },
  },
  margin: {
    l: 140,
    r: 40,
    b: 50,
    t: 80
  },
  legend: {
    font: {
      size: 10,
    },
    yanchor: 'middle',
    xanchor: 'right'
  },
  width: 600,
  height: 600,
  paper_bgcolor: 'rgb(247, 247, 247)',
  plot_bgcolor: 'rgb(247, 247, 247)',
  hovermode: 'closest'
};

// Plotly.newPlot('chart-moyen-rea', data, layout);

var lieux_elements = document.querySelectorAll(".li_lieux")

    lieux_elements.forEach(function (element) {
      element.addEventListener("mouseover", function( event ) {
        event.target.style.color = "orange";
        setTimeout(function() {
          event.target.style.color = "";
        }, 150);
      }, false);
    })

  function selectAll(source){
    console.log('here');
    checkboxes = document.querySelectorAll(".checkPlaces")
    checkboxes.forEach(function(element){
      element.checked = source.checked;
    });

  }
</script>
