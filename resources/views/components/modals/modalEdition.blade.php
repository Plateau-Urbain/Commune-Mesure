<span class="icon-edit" style="position: absolute;">
    <i class="fa fa-pen modal-crayon" data-modal="{{$chemin}}" title="Éditer la section"></i>
</span>
<div class="modal" id="{{$chemin}}" style="z-index: 100000;">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier le texte</p>
      <i class="fas fa-times modal-croix" title="Fermer modale" ></i>
    </header>
    <form method="POST" id="" action="">
      <section class="modal-card-body">

        @php($valueChemin =\app\Models\Place::getValueByChemin($place,$chemin))
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
                      <input class="input" type="text" value="{{$v}}">
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            <hr/>
          @endforeach
        @else
        <textarea class="textarea">{{ $valueChemin }}</textarea>
        @endif
        <span style="opacity: 0.2;">$place->{{ $chemin }}</span>
      </section>
      <footer class="modal-card-foot">
        <button class="button" type="submit">Enregistrer</button>
      </footer>
    </form>
  </div>
</div>
