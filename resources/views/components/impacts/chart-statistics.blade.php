<script>
  var compares = JSON.parse("{{ json_encode($compares) }}".replace(/&quot;/g,'"'));
  var places_name = JSON.parse("{{ json_encode($compares) }}".replace(/&quot;/g,'"'));

  function comparePlacePoints(selectcmpL, selectcmpR){

    var leftTitle = selectcmpL.options[selectcmpL.selectedIndex].text;
    var rightTitle = selectcmpR.options[selectcmpR.selectedIndex].text;
    if(leftTitle == '--' || rightTitle == "--"){
      console.log(selectcmpL);
      console.log(selectcmpR);
        return;
    }

    if(leftTitle == rightTitle){
      alert("Vous ne pouvez pas comparer un même lieu.");
      return;
    }
    document.getElementById("titleCmpLeft").innerHTML = leftTitle;
    document.getElementById("titleCmpRight").innerHTML = rightTitle;

    document.getElementById("cmpBlock").style.display = "block";
  }

var ordonnee = [], abscisse = [];
for (const [key, value] of Object.entries(compares.data)) {
  console.log(`${key}: ${value}`);
  ordonnee.push(value.moyens.etp.nombre);
  abscisse.push(value.realisations.event.nombre);
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
      color: '#ee4035',
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
  paper_bgcolor: 'rgb(254, 247, 234)',
  plot_bgcolor: 'rgb(254, 247, 234)',
  hovermode: 'closest'
};

Plotly.newPlot('chart-moyen-rea', data, layout);

</script>
