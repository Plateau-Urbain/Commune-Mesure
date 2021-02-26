<script>

var values = @json($place->get('structure->activities'));
var colors = ['#E85048', '#DEEBEE', '#F3771B', '#B5BF8A', 'orange', '#E3386A', '#d6d8ff', 'grey', '#b1bfac', '#fcba03', '#FFB7B2', '#B5EAD7', '#C7CEEA', '#FF9AA2','#E85048', '#DEEBEE', '#617D8C', '#F3771B', '#B5BF8A'];

var theta = [];

function setCircle(n, rx, ry, id) {
    var main = document.getElementById(id);
    var mainHeight = parseInt(window.getComputedStyle(main).height.slice(0, -2));
    var circleArray = [];
    for (var i = 0; i < n; i++) {
        var circleChild = document.createElement('div');
        circleChild.className = 'value_item-child';
        var textChild = document.createElement("p")
        textChild.className = "value_text_child"
        textChild.innerHTML = childrens[i].text
        circleChild.appendChild(textChild)
        circleArray.push(circleChild);
        circleArray[i].posx = Math.round(rx * (Math.cos(theta[i]))) + 'px';
        circleArray[i].posy = Math.round(ry * (Math.sin(theta[i]))) + 'px';
        circleArray[i].style.position = "absolute";
        circleArray[i].style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        circleArray[i].style.transform = "translate(-50%,-50%)";
        circleArray[i].style.top = ((mainHeight / 2) - parseInt(circleArray[i].posy.slice(0, -2))) + 'px';
        circleArray[i].style.left = ((mainHeight / 2) + parseInt(circleArray[i].posx.slice(0, -2))) + 'px';

        main.appendChild(circleArray[i]);
        // main.addEventListener("mouseover", function( event ) { circleChild[i].style.opacity = "1"; }, false);
    }
};
function circleGenerator(number, rx, ry, id) {
    theta = [];
    var circle = 360 / number;
    for (var i = 0; i <= number; i++) {
        theta.push((circle / 180) * i * Math.PI);
    }
    setCircle(number, rx, ry, id)
}

for (const [key, value] of Object.entries(values)) {
  var container = document.getElementById("value_container")
  var mainCircle = document.createElement("div")
  mainCircle.id = "circle" + value.text;
  mainCircle.className = "value_item";
  mainCircle.style.backgroundColor = colors[Math.floor(Math.random()*10)]
  mainCircle.style.backgroundColor = "#F1F1F1"
  var text = document.createElement("p")
  text.innerHTML = value.text
  text.className = "value_text";
  mainCircle.appendChild(text);
  container.appendChild(mainCircle)
  var childrens = value.children
  circleGenerator(childrens.length, 100, 100, mainCircle.id);
}
</script>
