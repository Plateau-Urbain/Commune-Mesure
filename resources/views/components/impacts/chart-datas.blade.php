<script>
var colors = ["#ee4035", "#f37736", "#fdf498", "#7bc043", "#0392cf",
"#d11141", "#f37735", "#7e8d98", "#29a8ab", "#3d1e6d", "#c68642", "#d2e7ff"];

  //TODO move that function because is used also in other page
var i = 0;
var values;

var order = @json($resiliences['order']);
var place = @json($resiliences['byPlace']);
var section = document.getElementById('sectionResilienceBar')

function createResilienceBar(select) {
    var bars = []
    var type = select.value

    const keys = Object.keys(order[type])

    keys.forEach(function (key) {
        var list = ''
        list += type + ': ' + order[type][key] + '|'
        Object.keys(place[key]).forEach(function (k) {
            if (k == type) {
                return false
            }
            list += k + ': ' + place[key][k] + '|'
        })
        console.log(key + ': ' + list)
    })
}




function move(element) {
  var width = 10;
  if (i == 0) {
    i = 1;
    var elem = element;
    var id = setInterval(frame, 10);
    var fill = parseInt(element.dataset.fill);
    var full = parseInt(element.dataset.full);
    var widthfill = (fill/full)*100;
    function frame() {
      if (width >= widthfill) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
        elem.innerHTML = width  + "%";
      }
    }
  }
}


  function computePercent(total, city, length){

    return (30*city/total);
  }
  var node;
  function createResilienceBar(select){

    var resilienceType = select.value;
    var resilience;
    var sectionResilienceBar = document.getElementById('sectionResilienceBar');

    var templateProgress = document.querySelector('#template-progress');
    var templateProgressItemMedium = document.querySelector('#template-progress-item-medium');
    var templateProgressItemStart = document.querySelector('#template-progress-item-start');
    var templateProgressItemEnd = document.querySelector('#template-progress-item-end');
    var templateTitlePlace = document.querySelector('#template-title-place');
    var templateLinkPlace = document.querySelector('#template-link-place');
    var templateIndicateurColumns = document.querySelector('#template-indicateur-columns');
    var templateIndicateurColumn = document.querySelector('#template-indicateur-column');

    var length = {{ count((array)$places[0]->data->resilience) }} -1; //Minus 1 for total field
    var position = 0;
    sectionResilienceBar.textContent = null;

    @foreach($places as $place)
      var divProgress = document.importNode(templateProgress.content, true).firstElementChild.firstElementChild;
      var progressItemMedium;
      var medium = [];
      var progressItemEnd;
      var progressItemStart;
      var pTitle = document.importNode(templateTitlePlace.content, true).firstElementChild;
      var a = document.importNode(templateLinkPlace.content, true).firstElementChild;
      var divColumnsResilience = document.importNode(templateIndicateurColumns.content, true).firstElementChild;
      var divColumnDetail = document.importNode(templateIndicateurColumn.content, true).firstElementChild;
      var divColumnBar = document.importNode(templateIndicateurColumn.content, true).firstElementChild;

      position = 1;
      a.setAttribute('href',"{{ route('place.show',['slug' => $place->title])  }}");
      a.textContent = "{{ $place->name }}";
      pTitle.appendChild(a);
      divColumnDetail.appendChild(pTitle);
      divColumnsResilience.appendChild(divColumnDetail)
      var resiliences = JSON.parse("{{ json_encode($place->data->resilience) }}".replace(/&quot;/g,'"'));
      var total = resiliences[length].total
      @foreach($place->data->resilience->type as $type_resilience => $resilience)

          @if(property_exists($resilience, 'key') !== false)
            var resilience = JSON.parse("{{ json_encode($resilience) }}".replace(/&quot;/g,'"'));
            if(resilienceType == "{{ $resilience->key }}"){
                progressItemStart = document.importNode(templateProgressItemStart.content, true).firstElementChild;
                progressItemStart = progressBar(resilience, progressItemStart, total);
                progressItemStart.style.backgroundColor = colors[position];
            }
            if(position > 1 && position < length){
              progressItemMedium = document.importNode(templateProgressItemMedium.content, true).firstElementChild;
              progressItemMedium = progressBar(resilience, progressItemMedium, total);
              progressItemMedium.style.backgroundColor = colors[position];
              medium.push(progressItemMedium);
            }
            if(position == length){
              progressItemEnd = document.importNode(templateProgressItemEnd.content, true).firstElementChild;
              progressItemEnd = progressBar(resilience, progressItemEnd, total);
              progressItemEnd.style.backgroundColor = colors[position];
            }
            position++;
        @endif

      @endforeach

      divProgress.appendChild(progressItemStart);
      for (var i = 0; i < medium.length; i++) {
       divProgress.appendChild(medium[i])
      }
      //console.log(progressItemEnd)
      divProgress.appendChild(progressItemEnd);

      divColumnBar.appendChild(divProgress);

      divColumnsResilience.appendChild(divColumnBar);
      sectionResilienceBar.appendChild(divColumnsResilience);
    @endforeach
  }
  function progressBar(resilience, progressItem, total){
    progressItem.setAttribute('data-fill', resilience.city);
    progressItem.setAttribute('data-full', total);
    let percent = (30*resilience.city/total);
    progressItem.style.width = percent.toString()+"em";
    progressItem.setAttribute("data-tooltip", resilience.title+" : "+(percent.toFixed(2)*100).toString() + "%");
    return progressItem;
  }


</script>
