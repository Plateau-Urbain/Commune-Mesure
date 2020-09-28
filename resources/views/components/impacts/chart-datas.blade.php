
<template id="chromosomic-row">
    <div class="columns">
        <div class="column is-4">
            <p class="title is-4">
                <a href=""></a>
            </p>
        </div>
        <div class="column is-8 has-text-centered">
            <div class="chromosomic"></div>
        </div>
    </div>
</template>

<script>

//TODO move that function because is used also in other page
var order = @json($resiliences['order']);
var place = @json($resiliences['byPlace']);
var infos = @json($resiliences['places']);

var section = document.getElementById('sectionResilienceBar')
var chromosomesTemplate = document.querySelector('#chromosomic-row')

function createResilienceBar(select) {
    _clean(section)

    var type = select.value
    const keys = Object.keys(order[type])

    keys.forEach(function (key) {
        // on clone le template
        var line = document.importNode(chromosomesTemplate.content, true)
        var chromosomic = line.querySelector('.chromosomic')

        // Titre du chromosome (le lieu)
        link = line.querySelector('p.title > a')
        link.href = infos[key].url
        link.textContent = key.trim()

        // On créé le premier div du chromosome
        var color = 0
        var total = infos[key].total
        var firstdiv = document.createElement('div')

        _style(firstdiv, type, order[type][key], total)
        firstdiv.dataset.tooltip = order[type][key] + '%'
        chromosomic.appendChild(firstdiv)

        Object.keys(place[key]).forEach(function (k) {
            if (k == type) {
                return false
            }

            var div = document.createElement('div')
            _style(div, k, place[key][k], total)
            div.dataset.tooltip = place[key][k] + '%'
            chromosomic.appendChild(div)
            color++
        })

        section.appendChild(line)
    })
}

function _clean(div) {
    while(div.firstChild) {
        div.removeChild(div.lastChild)
    }
}

function _style(div, color, width, total) {
    div.classList.add(color+'-color');
    div.style.width = (width * 100) / total + '%'
}
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

var options = {

  colors:['#e34c26','#f07d60','#A5C5C3', '#429F9E'],

  series: [{name: '',data: [{{ $quantity1 *100}}]},{name: '',data: [{{ $quantity2*100 }}]},{name: '',data: [{{ $quantity3 *100}}]},{name: '',data: [{{ $quantity4 *100}}]}],
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

var resilienceChart = new ApexCharts(document.querySelector("#resilienceChart"), options);
resilienceChart.render();

</script>
