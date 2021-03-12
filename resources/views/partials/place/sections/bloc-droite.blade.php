<div class="bloc-note">
  <div class="header-bloc-note">
    <figure class="image">
      <img src="/images/bloc_noteAsset.png">
    </figure>
  </div>
  <div class="bloc-note-body">
    <div class="content">
      @if($place->get('blocs->presentation->donnees->acteurs_publics') || isset($edit))
          <div>
            <strong>Les acteurs publics : </strong>
            <span class="is-block is-size-7">
              {{ $place->get('blocs->presentation->donnees->acteurs_publics') }}
              @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->acteurs_publics','type' => 'text','titre'=>"Modifier Les acteurs publics",'description'=>"Qui sont les acteurs publics ?"])
            </span>
          </div>
      @endif
      @if ($place->get('blocs->presentation->donnees->acteurs_prives') || isset($edit))
          <div>
            <strong>Les acteurs privés : </strong>
            <span class="is-block is-size-7">
              {{ $place->get('blocs->presentation->donnees->acteurs_prives') }}
              @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->acteurs_prives','type' => 'text','titre'=>"Modifier Les acteurs privés",'description'=>"Qui sont les acteurs privés ?"])
            </span>
          </div>
      @endif
        <div class="">
          <strong class="">Nature des partenariats :</strong>
          <div class="is-size-7">
            @if($place->get('blocs->presentation->donnees->natures_partenariats->public') || isset($edit))
              <div> Publics : <span class="font-color-theme">
                  @foreach($place->get('blocs->presentation->donnees->natures_partenariats->public') as $nature)
                    {{ $nature }}@if(! $loop->last), @endif
                  @endforeach
                </span>
                @include('components.modals.modalEdition',['chemin'=> 'blocs->presentation->donnees->natures_partenariats->public','type' => 'text','titre'=>"Modifier La nature des partenariats",'description'=>'Quelles sont les natures de partenariats avec les acteurs du publics ?'])
              </div>
            @endif
            @if($place->get('blocs->presentation->donnees->natures_partenariats->prive') || isset($edit))
              <div> Privés : <span class="font-color-theme">
                @foreach($place->get('blocs->presentation->donnees->natures_partenariats->prive') as $nature)
                  {{ $nature}}@if(! $loop->last), @endif
                @endforeach
                </span>
                @include('components.modals.modalEdition',['chemin'=> 'blocs->presentation->donnees->natures_partenariats->prive','type' => 'text','titre'=>"Modifier La nature des partenariats",'description'=>'Quelles sont les natures de partenariats avec les acteurs du privé ?'])
              </div>
            @endif
          </div>
        </div>

    </div>
  </div>
</div>
