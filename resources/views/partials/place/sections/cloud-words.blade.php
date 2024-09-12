<div class="cloud-layer">
  <div class="cloud">
    @include('components.modals.modalEdition',['chemin'=>'blocs->impact_social->donnees->mots_cles_effets_individuels','link_text' => 'Modifier les effets individuels', 'id_section'=>'impact','type'=>'text','titre'=>"Modifier les mots clés des effets individuels",'description'=>"Modifier les mots clés des effets individuels, séparés par une virgule"])
    @include('components.modals.modalEdition',['chemin'=>'blocs->impact_social->donnees->mots_cles_effets_collectifs','link_text' => 'Modifier les effets collectifs', 'id_section'=>'impact','type'=>'text','titre'=>"Modifier les mots clés des effets collectifs",'description'=>"Modifier les mots clés des effets collectifs, séparés par une virgule"])
    @include('components.modals.modalEdition',['chemin'=>'blocs->impact_social->donnees->mots_cles_effets_territoriaux','link_text' => 'Modifier les effets territoriaux', 'id_section'=>'impact','type'=>'text','titre'=>"Modifier les mots clés des effets territoriaux",'description'=>"Modifier les mots clés des effets territoriaux, séparés par une virgule"])

    @foreach (explode(',', $place->get("blocs->impact_social->donnees->mots_cles_effets_individuels")) as $key => $word)
      @if (!empty(trim($word)))
        <span class="word word-{{$key}}">#{{trim($word)}}</span>
      @endif
    @endforeach
    @foreach (explode(',', $place->get("blocs->impact_social->donnees->mots_cles_effets_collectifs")) as $key => $word)
      @if (!empty(trim($word)))
        <span class="word word-{{$key}}">#{{trim($word)}}</span>
      @endif
    @endforeach
    @foreach (explode(',', $place->get("blocs->impact_social->donnees->mots_cles_effets_territoriaux")) as $key => $word)
      @if (!empty(trim($word)))
        <span class="word word-{{$key}}">#{{trim($word)}}</span>
      @endif
    @endforeach
  </div>
</div>
