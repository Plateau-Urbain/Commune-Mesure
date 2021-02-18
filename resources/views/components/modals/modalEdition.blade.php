<div class="modal" id="{{$section}}" style='padding-top:40px'>
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier le texte</p>
      <i class="fas fa-times modal-croix" title="Fermer modale" ></i>
    </header>
    <form method="POST" id="" action="{{route('place.update',['slug' => $slug, 'auth' => $auth , 'section'=>$section])}}">
      <section class="modal-card-body">

        @if(in_array($section,['bloc_gauche','gouvernance_partagee','acteurs_publics','acteurs_prives','nature_partenariats','appartenance','reseaux','sante','lien','insertion','capacite']))
            <textarea id="{{$section}}" name="{{$section}}" style='width:600px;height:200px'>
              @if($section =='bloc_gauche')
                {{$place->description->value}}
              @endif
            </textarea>
            <input hidden id='arborescence' name='arborescence'value="description->value"</input><!-- donner le chemin dans l'arborescence  -->
        @elseif(in_array($section, ['bloc_droite','nb_struct_occupants','surface','nb_etp']))
            <input type='number'></input>
        @else
        @endif

      </section>
      <footer class="modal-card-foot">
        <button type="submit">Enregistrer</button>
      </footer>
    </form>
  </div>
</div>
