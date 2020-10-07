<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>

var values = JSON.parse("{{ json_encode($place->structure->activities) }}".replace(/&quot;/g,'"'));
var applications = JSON.parse("{{ json_encode($place->structure->merits) }}".replace(/&quot;/g,'"'));
var randomColors = ["#E85048","#DEEBEE","#617D8C","#F3771B","#B5BF8A","#E3386A","#d6d8ff","#b1bfac","#fcba03"]

var radius = 150;
var main = document.getElementById('value_container');
var mainHeight = parseInt(window.getComputedStyle(main).height.slice(0, -2));
var theta = [0, (2 * (Math.PI / 15)), (4 * (Math.PI / 15)), (2 * (Math.PI / 5)), (8 * (Math.PI / 15)), (2 * (Math.PI / 3)), (4 * (Math.PI / 5)), (14 * (Math.PI / 15)), (16 * (Math.PI / 15)), (6 * (Math.PI / 5)), (4 * (Math.PI / 3)), (22 * (Math.PI / 15)), (8 * (Math.PI / 5)), (26 * (Math.PI / 15)), (28 * (Math.PI / 15))];
var circleArray = [];

var colors = ['red', 'green', 'purple', 'black', 'orange', 'yellow', 'maroon', 'grey', 'lightblue', 'tomato', 'pink', 'maroon', 'cyan', 'magenta', 'blue', 'chocolate', 'DarkSlateBlue'];
console.log(theta)

for (const [key, value] of Object.entries(values)) {
  var i =0;
  var container = document.getElementById("value_container")
  var newDiv = document.createElement("div")
  newDiv.className = "value_item";
  newDiv.style.backgroundColor = randomColors[Math.floor(Math.random() * (7 - 1 + 1) + 1)]
  var text = document.createElement("p")
  text.innerHTML = value.text
  text.className = "value_text";
  newDiv.appendChild(text);
  container.appendChild(newDiv)

  childrens = applications;
  // for (var i = 0; i < children.length; i++) {
  //   children[i]
  // }

  childrens.forEach(function(element){

    i= i+2;
    console.log(theta.length)
    console.log(i)
    var newChild = document.createElement("div")
    newChild.className = "value_item_child";
    var textChild = document.createElement("p")
    textChild.className = "value_text"
    textChild.innerHTML = element.text
    newChild.appendChild(textChild)

    newChild.posx = Math.round(radius * (Math.cos(theta[i]))) + 'px';
    newChild.posy = Math.round(radius * (Math.sin(theta[i]))) + 'px';
    console.log(Math.round(radius * (Math.sin(theta[i]))))
    newChild.style.position = "absolute";
    newChild.style.backgroundColor = randomColors[Math.floor(Math.random() * (7 - 1 + 1) + 1)]
    newChild.style.top = ((mainHeight / 2) - parseInt(newChild.posy.slice(0, -2))) + 'px';
    newChild.style.left = ((mainHeight / 2) + parseInt(newChild.posx.slice(0, -2))) + 'px';
    console.log(newChild.posx,newChild.posy,newChild.style.top)
    newDiv.appendChild(newChild)

    newDiv.addEventListener("mouseover", function( event ) {
      newChild.style.opacity = "1"; }, false);
  });




}
        //
        // var options = {
        //   series: [{
        //   name: 'Bubble1',
        //   data: [[10,60,10]]
        // },
        // {
        //   name: 'Bubble4',
        //   data: [[10,0,10]]
        // }],
        //   chart: {
        //     height: 350,
        //     type: 'bubble',
        //     toolbar:{
        //       show:false,
        //     }
        // },
        // dataLabels: {
        //     enabled: false
        // },
        // fill: {
        //     opacity: 0.8
        // },
        // title: {
        //     text: ''
        // },
        // grid: {
        //   show:false,
        // },
        // annotations: {
        //   x:'',
        // },
        // xaxis: {
        //   show:false,
        //   axisBorder:{
        //     show:false,
        //   },
        //   lines: {
        //     show: false,
        //   }
        // },
        // yaxis: {
        //   show:false,
        //   axisBorder:{
        //     show:false,
        //   },
        //   lines: {
        //     show: true,
        //   }
        // },
        // legend:{
        //   show:false,
        // }
        //
        // };
        //
        // var valuesChart = new ApexCharts(document.querySelector("#valuesChart"), options);
        // valuesChart.render();

</script>
