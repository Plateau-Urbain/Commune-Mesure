<script>

  var activitiesMerits = JSON.parse("{{ json_encode($place->structure) }}".replace(/&quot;/g,'"'));
  var myActivities = activitiesMerits.theme;
  var myMerits = activitiesMerits.merits;

  var margin = {top: 10, right: 10, bottom: 10, left: 10},
  width = 500 - margin.left - margin.right,
  height = 450 - margin.top - margin.bottom;

  var svg = d3.select("#d3-cloud").append("svg")
  .attr("width", width + margin.left + margin.right)
  .attr("height", height + margin.top + margin.bottom)
  .append("g")
  .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
  var layout = d3.layout.cloud()
  .size([width, height])
  .words(myActivities.concat(myMerits).map(function(d) { return {text: d}; }))
  .padding(10)
  .fontSize(15)
  .on("end", draw);
  layout.start();
  function draw(words) {
  svg.append("g")
    .attr("transform", "translate(" + layout.size()[0] / 2 + "," + layout.size()[1] / 2 + ")")
    .selectAll("text")
    .data(words)
    .enter().append("text")
      .style("font-size", function(d) { return d.text.size + "px"; })
      .attr("text-anchor", "middle")
      .style("fill", function(d) { return d.text.color; })
      .attr("transform", function(d) {
        return "translate(" + [d.x, d.y] + ")";
      })
      .text(function(d) { return d.text.text; });
  }
</script>
<!--
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

var options = {

  series: [{
  name: '',
  data: [0]
  }],
  chart: {
  type: 'bar',
  height: 130,
  stacked: true,
  stackType: '100%',
  toolbar:{
    show:false,
  },
},
plotOptions: {
  bar: {
    horizontal: true,
  },
},
stroke: {
  width: 1,
  colors: ['#fff']
},
title: {
  text: 'Actifs'
},
grid: {
  show:false,
},
annotations: {
},

xaxis: {
  show:false,
  category:[''],
  axisBorder:{
    show:false,
  },
  axisTicks: {
    show: false,
  },
  labels:{
    show:false,
  }
},

yaxis: {
  show:false,
  category:[''],
  axisBorder:{
    show:false,
  },
},

tooltip: {
  x:'',
  y: {
    formatter: function (val) {
      return val + "%"
    }
  }
},
fill: {
  opacity: 1

},
legend: {
  position: 'bottom',
  horizontalAlign: 'left',
  offsetX: 40,
}
};

var actifChart = new ApexCharts(document.querySelector("#actifsChart"), options);
actifChart.render();

var options = {

  series: [{
  name: '',
  data: [0]
  }],
  chart: {
  toolbar:{
    show:false,
  },
  type: 'bar',
  height: 160,
  stacked: true,
  stackType: '100%',
},
plotOptions: {
  bar: {
    horizontal: true,
  },
},
stroke: {
  width: 1,
  colors: ['#fff']
},
title: {
  text: 'Catégories socioprofessionnelles'
},
grid: {
  show:false,
},
annotations: {
},

xaxis: {
  show:false,
  category:[''],
  axisBorder:{
    show:false,
  },
  axisTicks: {
    show: false,
  },
  labels:{
    show:false,
  }
},

yaxis: {
  show:false,
  category:[''],
  axisBorder:{
    show:false,
  },
},

tooltip: {
  x:'',
  y: {
    formatter: function (val) {
      return val + "%"
    }
  }
},
fill: {
  opacity: 1

},
legend: {
  position: 'bottom',
  horizontalAlign: 'left',
  offsetX: 40
}
};

var categoryChart = new ApexCharts(document.querySelector("#cateChart"), options);
categoryChart.render();

var options = {

  series: [{
  name: '',
  data: [0]
  }],
  chart: {
  type: 'bar',
  height: 130,
  stacked: true,
  stackType: '100%',
  toolbar:{
    show:false,
  },
  animations: {
    enabled: true,
    easing: 'easein',
    speed: 1200,
    animateGradually: {
        enabled: true,
        delay: 550
    },
    dynamicAnimation: {
        enabled: true,
        speed: 550
    }
  },
},
plotOptions: {
  bar: {
    horizontal: true,
  },
},
stroke: {
  show:true,
  curve: 'smooth',
  width: 1,
  colors: ['#fff'],
  lineCap: 'round',
},
title: {
  text: 'Immobiliers'
},
grid: {
  show:false,
},
annotations: {
},

xaxis: {
  show:false,
  category:[''],
  axisBorder:{
    show:false,
  },
  axisTicks: {
    show: false,
  },
  labels:{
    show:false,
  }
},

yaxis: {
  show:false,
  category:[''],
  axisBorder:{
    show:false,
  },
},

tooltip: {
  x:'',
  y: {
    formatter: function (val) {
      return val + "%"
    }
  }
},
fill: {
  opacity: 1

},
legend: {
  position: 'bottom',
  horizontalAlign: 'left',
  offsetX: 40
}
};

var immobilierChart = new ApexCharts(document.querySelector("#immoChart"), options);
immobilierChart.render();

var chart = new ApexCharts(document.querySelector("#myChart"), options);
chart.render();
</script>-->
