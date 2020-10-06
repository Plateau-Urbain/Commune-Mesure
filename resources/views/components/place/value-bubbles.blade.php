<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>

var values = JSON.parse("{{ json_encode($place->structure->activities) }}".replace(/&quot;/g,'"'));
var applications = JSON.parse("{{ json_encode($place->structure->merits) }}".replace(/&quot;/g,'"'));
var randomColors = ["#E85048","#DEEBEE","#617D8C","#F3771B","#B5BF8A","#E3386A","#d6d8ff","#b1bfac","#fcba03"]
console.log(values)
console.log(applications)
var mainHeight = 100;
var radius = 150;
var theta = [0, (2 * (Math.PI / 15)), (4 * (Math.PI / 15)), (2 * (Math.PI / 5)), (8 * (Math.PI / 15)), (2 * (Math.PI / 3)), (4 * (Math.PI / 5)), (14 * (Math.PI / 15)), (16 * (Math.PI / 15)), (6 * (Math.PI / 5)), (4 * (Math.PI / 3)), (22 * (Math.PI / 15)), (8 * (Math.PI / 5)), (26 * (Math.PI / 15)), (28 * (Math.PI / 15))];

for (const [key, value] of Object.entries(values)) {
  console.log(value.text)
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

  childrens.forEach(function(element){
    var newChild = document.createElement("div")
    newChild.className = "value_item_child";
    var textChild = document.createElement("p")
    textChild.className = "value_text"
    textChild.innerHTML = element.text
    newChild.appendChild(textChild)
    container.appendChild(newChild)

    newChild.posx = Math.round(radius * (Math.cos(theta[i]))) + 'px';
    newChild.posy = Math.round(radius * (Math.sin(theta[i]))) + 'px';
    newChild.style.position = "absolute";
    newChild.style.top = ((mainHeight / 2) - parseInt(newChild.posy.slice(0, -2))) + 'px';
    newChild.style.left = ((mainHeight / 2) + parseInt(newChild.posx.slice(0, -2))) + 'px';
    newDiv.addEventListener("mouseover", function( event ) {
      newChild.style.display = "block";
      setTimeout(function() { newChild.style.display = "none";}, 500);
    }, false);
  });

  function setCircleMerits() {
  var radius = 150;
  var main = document.getElementById('value_container');
  var mainHeight = parseInt(window.getComputedStyle(main).height.slice(0, -2));
  var theta = [0, (2 * (Math.PI / 15)), (4 * (Math.PI / 15)), (2 * (Math.PI / 5)), (8 * (Math.PI / 15)), (2 * (Math.PI / 3)), (4 * (Math.PI / 5)), (14 * (Math.PI / 15)), (16 * (Math.PI / 15)), (6 * (Math.PI / 5)), (4 * (Math.PI / 3)), (22 * (Math.PI / 15)), (8 * (Math.PI / 5)), (26 * (Math.PI / 15)), (28 * (Math.PI / 15))];
  var circleArray = [];
  var colors = ['red', 'green', 'purple', 'black', 'orange', 'yellow', 'maroon', 'grey', 'lightblue', 'tomato', 'pink', 'maroon', 'cyan', 'magenta', 'blue', 'chocolate', 'DarkSlateBlue'];
  for (var i = 0; i < 6; i++) {
    var circle = document.createElement('div');
    circle.className = 'circle number' + i;
    circleArray.push(circle);
    circleArray[i].posx = Math.round(radius * (Math.cos(theta[i]))) + 'px';
    circleArray[i].posy = Math.round(radius * (Math.sin(theta[i]))) + 'px';
    circleArray[i].style.position = "absolute";
    circleArray[i].style.backgroundColor = colors[i];
    circleArray[i].style.top = ((mainHeight / 2) - parseInt(circleArray[i].posy.slice(0, -2))) + 'px';
    circleArray[i].style.left = ((mainHeight / 2) + parseInt(circleArray[i].posx.slice(0, -2))) + 'px';
    main.appendChild(circleArray[i]);
  }
};
setCircleMerits();



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
