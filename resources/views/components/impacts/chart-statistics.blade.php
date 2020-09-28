<script>
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

    loadCompare("#compareLeftTop", 50);
    loadCompare("#compareRightTop", 82);
    loadCompare("#compareLeftBottom", 20);
    loadCompare("#compareRightBottom", 15);
    document.getElementById("cmpBlock").style.display = "block";
  }

  var country = ['Switzerland (2011)', 'Chile (2013)', 'Japan (2014)', 'United States (2012)', 'Slovenia (2014)', 'Canada (2011)', 'Poland (2010)', 'Estonia (2015)', 'Luxembourg (2013)', 'Portugal (2011)'];


var etp = [40, 45.7, 52, 53.6, 54.1, 54.2, 54.5, 54.7, 55.1, 56.6];

var even = [49.1, 42, 52.7, 84.3, 51.7, 61.1, 55.3, 64.2, 91.1, 58.9];

var trace1 = {
  type: 'scatter',
  x: etp,
  y: even,
  mode: 'markers',
  name: 'Rapport entre le nombre ETP et Évènement',
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
    tickcolor: '#29a8ab'
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

Plotly.newPlot('chart-moyen-rea', data, layout);

var lieux_elements = document.querySelectorAll(".li_lieux")

lieux_elements.forEach(function (element) {
  element.addEventListener("mouseover", function( event ) {
    event.target.style.color = "orange";
    setTimeout(function() {
      event.target.style.color = "";
    }, 600);
  }, false);
})
</script>
