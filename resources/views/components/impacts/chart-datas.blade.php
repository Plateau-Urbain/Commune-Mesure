<script>

  //TODO move that function because is used also in other page
  var i = 0;
  var values;

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

  function createResilienceBar(select){
    var resilience = select.value;
    var sectionResilienceBar = document.getElementById('sectionResilienceBar');
    sectionResilienceBar.textContent = null;
    @foreach($places as $place)
      @foreach($place->data->resilience as $type_resilience => $resilience)
        if("{{ $type_resilience }}" == resilience && "{{ $type_resilience }}" != "survey"){
          var divColumnsResilience = document.createElement('div');
          var divColumnBar = document.createElement('div');
          var divColumnDetail = document.createElement('div');
          var divProgress = document.createElement('div');
          var divBar = document.createElement('div');
          var pTitle = document.createElement('p');
          var pDetail = document.createElement('p');
          var a = document.createElement('a');

          a.setAttribute('href',"{{ route('place.show',['slug' => $place->title])  }}");
          a.textContent = "{{ $place->name }}";
          pTitle.appendChild(a);
          pTitle.setAttribute('class', 'title is-4 no-border');
          divColumnDetail.appendChild(pTitle);
          divColumnDetail.setAttribute('class', 'column');
          pDetail.textContent = "Les données permettent de ressortir";
          divColumnDetail.appendChild(pDetail);


          divProgress.setAttribute('id', 'myProgress');
          divBar.setAttribute('class', 'myBar');
          let resilience = JSON.parse("{{ json_encode($resilience) }}".replace(/&quot;/g,'"'));
          divBar.setAttribute('data-fill', resilience.city);
          divBar.setAttribute('data-full', resilience.total);
          divBar.textContent = "10%";

          divProgress.appendChild(divBar);

          divColumnBar.setAttribute('class', 'column');
          divColumnBar.appendChild(divProgress);



          divColumnsResilience.setAttribute('class', 'columns');
          divColumnsResilience.appendChild(divColumnDetail)
          divColumnsResilience.appendChild(divColumnBar);
          sectionResilienceBar.appendChild(divColumnsResilience);
        }

      @endforeach
    @endforeach
    values = document.querySelectorAll(".myBar")
    values.forEach(function (v) {
        move(v)
        i=0;
    })
  }

</script>
