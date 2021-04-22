<script>

var options = {

  colors:['#F05F3B','#f07d60','#A5C5C3', '#429F9E', '#007872'],

  series: [{
  name: '',
  data: [0]
  }],
  chart: {
  type: 'bar',
  height: 175,
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
  text: 'Population',
  floating : true
},
grid: {
  show:false,
},
annotations: {
},

xaxis: {
    show:false,
    categories:['Niveau national','Niveau '+document.getElementById("selectGeo").value],
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

tooltip: {
  x: { formatter: function (val) { if (val == "Niveau national") return "Niveau national"; return "Niveau "+select_zone;}},
  y: {
    formatter: function (val) {
      return val.toFixed(2) + "%"
    }
  }
},
fill: {
  opacity: 1

},
legend: {
  show:true,
  position: 'bottom',
  horizontalAlign: 'right',
  showForZeroSeries: false,
}
};

var actifChart = new ApexCharts(document.querySelector("#actifsChart"), options);
actifChart.render();

var options = {
    colors:['#bf607e', '#ca4a3d', '#e3a7a1','#fcd2bb','#c7dfec','#81b8d6','#3680b6','#1b519c'],

    series: [{
        name: '',
        data: [0]
    }],
    chart: {
        toolbar:{
            show:false,
        },
        type: 'bar',
        height: 175,
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
        categories:['Niveau national','Niveau '+document.getElementById("selectGeo").value],
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

    tooltip: {
        x: { formatter: function (val) { if (val == "Niveau national") return "Niveau national"; return "Niveau "+select_zone;}},
        y: {
            formatter: function (val) {
                return val.toFixed(2) + "%"
            }
        }
    },
    fill: {
        opacity: 1

    },
    legend: {
        show:true,
        position: 'bottom',
        horizontalAlign: 'right',
        showForZeroSeries: false,
    }
};

var cspChart = new ApexCharts(document.querySelector("#cateChart"), options);
cspChart.render();


var options = {
  colors:['#E1E1E1', '#456EB8', '#F3771B'],

  series: [{
  name: '',
  data: [0]
  }],
  chart: {
  type: 'bar',
  height: 175,
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
  text: 'Immobilier'
},
grid: {
  show:false,
},
annotations: {
},

xaxis: {
    show:false,
    categories:['Niveau national','Niveau '+document.getElementById("selectGeo").value],
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

tooltip: {
  x: { formatter: function (val) { if (val == "Niveau national") return "Niveau national"; return "Niveau "+select_zone;}},
  y: {
    formatter: function (val) {
      return val.toFixed(2) + "%"
    }
  }
},
fill: {
  opacity: 1

},
legend: {
  show:true,
  position: 'bottom',
  horizontalAlign: 'right',
  showForZeroSeries: false,
}
};

var immobilierChart = new ApexCharts(document.querySelector("#immoChart"), options);
immobilierChart.render();
</script>
