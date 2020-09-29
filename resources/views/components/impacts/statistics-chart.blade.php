<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

var options = {

  colors:['#e34c26','#f07d60','#A5C5C3', '#429F9E'],

  series: [{name: 'Artistes',data: [{{ $quantity1 *100}}]},{name: 'Entreprises',data: [{{ $quantity2*100 }}]},{name: 'Associations',data: [{{ $quantity3 *100}}]},{name: 'Autres structures',data: [{{ $quantity4 *100}}]}],
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
  show:true,
  position: 'bottom',
  horizontalAlign: 'center',
  showForZeroSeries: false,
}
};

var compoChart = new ApexCharts(document.querySelector("#composition-chart"), options);
compoChart.render();

</script> -->
