<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@php ($quantity1 = $place->data->composition->{1}->nombre/$place->data->composition->{0}->nombre) @endphp
@php ($quantity2 = $place->data->composition->{2}->nombre/$place->data->composition->{0}->nombre) @endphp
@php ($quantity3 = $place->data->composition->{3}->nombre/$place->data->composition->{0}->nombre) @endphp
@php ($quantity4 = $place->data->composition->{4}->nombre/$place->data->composition->{0}->nombre) @endphp
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

var compoChart = new ApexCharts(document.querySelector("#compoChart"), options);
compoChart.render();

</script>
