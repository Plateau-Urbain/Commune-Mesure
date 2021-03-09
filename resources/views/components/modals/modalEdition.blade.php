@if(!isset($edit))
  @php return @endphp
@endif
<span class="icon-edit">
    <i class="fa fa-pen modal-crayon" data-modal="{{$chemin}}" title="Éditer la section" style="position:absolute;margin-top:-13px;"></i>
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

    <form method="POST" action="{{route('place.update',['slug' => $slug, 'auth' => $auth , 'chemin'=>$chemin])}}">

      <section class="modal-card-body">
        @if(isset($description))
          <small style='margin-left:10px'>
             {{$description}}
          </small>
          <hr style='border:1px solid #dbdbdb'>
        @endif
        @php ($valueChemin = $place->get($chemin))
        @if(is_array($valueChemin))
          @foreach($valueChemin as $key=>$value)
            @foreach ($value as $k=> $v)
              <div class="field is-horizontal">
                <div class="field-label is-normal">
                  <label class="label">{{ucfirst($k)}} :</label>
                </div>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      @if(is_array($v) && isset($type) && $type == 'checkbox')
                        @foreach($v as $kCheck => $vCheck)
                        <div class="field">
                          <div class="control">
                            <label class="checkbox">
                              <input type="checkbox" value="{{$kCheck}}" checked="checked">
                              {{ $vCheck }}
                            </label>
                          </div>
                        </div>
                        @endforeach
                      @elseif(is_array($v))
                      <textarea class="textarea">{{ implode("\n", $v) }}</textarea>
                      @elseif(!is_object($v))
                      <input class="input" type="text" value="{{$v}}">
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            <hr/>
          @endforeach
        @elseif( isset($type) && $type== 'text' )
          <textarea name='champ' class="textarea">{{ $valueChemin }}</textarea>
        @elseif( isset($type) && $type== 'number')
          <input class='input-number' name='champ' type='number' value = "{{ $valueChemin }}"/>
        @elseif ( isset($type) && $type == 'decimal')
          <input class='input-number'step="any" name='champ' type='number' value = "{{ $valueChemin }}"/>
        @elseif ( isset($type) && $type == 'date')
          <input class='input-number' step="any" name='champ' type='date' value = "{{ $valueChemin }}"/>
        @else
        <textarea name='champ' class="textarea">{{ $valueChemin }}</textarea>
        @endif




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
