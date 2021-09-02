@if(!isset($edit))
  @php return @endphp
@endif
<span class="icon-edit">
    <a class='crayons'href="#{{$id_section}}"><i class="fa fa-pen modal-crayon" data-modal="{{$chemin}}" title="Éditer"></i></a>
</span>
<div class="modal" id="{{$chemin}}" style="z-index: 100000;">
  <div class="modal-background" ></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <div class="modal-card-title">
        <h2 >
           @if(isset($titre))
              {{$titre}}
           @endif
         </h2>
      </div>
       <button class="delete modal-croix" aria-label="close"></button>
       <br>

    </header>

    <form method="POST" action="{{route('place.update',['slug' => $slug, 'auth' => $auth , 'chemin'=>$chemin, 'id_section' => $id_section])}}">

      <section class="modal-card-body">
        @if(isset($description))
          <small style='margin-left:10px'>
             {{$description}}
          </small>
          <hr style='border:1px solid #dbdbdb'>
        @endif

        @php ($valueChemin = $place->get($chemin)) @endphp
        @if(is_array($valueChemin))
          @if (isset($type) && $type =='text')
            @foreach( $valueChemin as $value)
            <input class='input' type='text' name="champ{{array_search($value,$valueChemin)}}"  value="{{ $value }}"/>
            @endforeach
            <input class='input' type='text' name="champ{{count($valueChemin)}}"></input>
            <input class='input' type='text' name="champ{{count($valueChemin)+1}}"></input>
            <input hidden name="type" value="{{$type}}"></input>
          @endif
        @elseif(is_object($valueChemin) && isset($type) && $type == "checkbox")
          @php $i=0; @endphp
          @foreach($valueChemin as $value => $check)
              @if($id_section == "valeurs")
                @php $maxCheck = 3;@endphp
                @if($check)
                  <input class='check checkbox-limitee' type="checkbox" name="{{$i}}" checked>
                @else
                  <input class='check checkbox-limitee' type="checkbox" name="{{$i}}">
                @endif
              @else
                @if($check)
                  @php $all=true; @endphp
                  <input class='check' type="checkbox" name="{{$i}}" checked>
                @else
                  <input class='check' type="checkbox" name="{{$i}}">
                @endif
              @endif
              <label class="checkbox"> {{$value}} </label>
            <br>
            @php $i++; @endphp
            <input hidden name="type" value="{{$type}}"></input>
          @endforeach

          @if(isset($all))
            <br>
            <input type="checkbox" onClick="toggle(this)"/>
            <label class="checkbox">Tout cocher</label>
            <br>
          @elseif(isset($maxCheck))
          <script>
          var checkbox = document.getElementsByClassName('checkbox-limitee');
          	for (var i = 0; i < checkbox.length; i++) {
          		checkbox[i].onclick = function() {
          			var checkedcount = 0;
          				for (var i = 0; i < checkbox.length; i++) {
          				checkedcount += (checkbox[i].checked) ? 1 : 0;
          			}
          			if (checkedcount > {{$maxCheck}}) {
          				alert("Vous pouvez séléctionner au maximum " + {{$maxCheck}} +" valeurs.");
          				this.checked = false;
          			}
          		}
          	}
          </script>
          @endif

        @elseif(is_object($valueChemin) && isset($type) && $type == "number")
          @php $i=0; @endphp
          @foreach($valueChemin as $k => $v)
            <label class ="labelpopup">{{$k}} : </label>
            <input class='input-number' type="number" name="{{$i}}" value="{{$v}}">
            <br>
            @php $i++; @endphp
            <input hidden name="type" value="{{$type}}"></input>
          @endforeach
        @elseif(is_object($valueChemin) && isset($type) && $type == "select")
          @php $choix = json_decode(json_encode($valueChemin),true) @endphp
            <div class="select">
              <select name='champ'>
                @foreach($choix as $k => $v)
                @if($v == 1)
                  <option selected>{{$k}}</option>
                @else
                  <option>{{$k}} </option>
                @endif
                @endforeach
              </select>
            </div>
            <input hidden name="type" value="{{$type}}"></input>
        @elseif( isset($type) && $type== 'text' )
          <textarea name='champ' class="textarea">{{ $valueChemin }}</textarea>
        @elseif( isset($type) && $type== 'number')
          <input class='input-number' name='champ' type='number' value = "{{ $valueChemin }}"/>
          <input hidden name="type" value="number"></input>
        @elseif ( isset($type) && $type == 'decimal')
          <input class='input-number'step="any" name='champ' type='number' value = "{{ $valueChemin }}"/>
          <input hidden name="type" value="number"></input>
        @elseif ( isset($type) && $type == 'date')
          <input class='input-number' name='champ' value="{{ $valueChemin }}" type="date" />
        @endif
        <br>
        <span style="opacity: 0.2;">$place->{{ $chemin }}</span>
      </section>
      <footer class="modal-card-foot">
        <input type="button" class="button modal-croix" value="Annuler"/>
        <span class="container">
          <span class="field is-grouped is-grouped-right">
            <button class="button is-success" type="submit">Enregistrer</button>
          </span>
        </span>
      </footer>
    </form>
  </div>
</div>
