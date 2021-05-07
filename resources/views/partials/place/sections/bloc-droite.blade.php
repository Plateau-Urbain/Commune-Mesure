<div class="bloc-note">
  <div class="header-bloc-note">
    <figure class="image">
      <img src="/images/Porte_bloc.png">
    </figure>
  </div>
  <div class="bloc-note-body">
    <br>
    <div class="content">
      @if($place->get('blocs->presentation->donnees->acteurs_publics') || isset($edit))
          <div>
            <h5>LES ACTEURS PUBLICS : </h5>
            <span class="is-block is-size-6">
              {{ $place->get('blocs->presentation->donnees->acteurs_publics') }}
              @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->acteurs_publics','id_section'=>'presentation','type' => 'text','titre'=>"Modifier les acteurs publics",'description'=>"Les acteurs publics partenaires ou soutien du projet"])
            </span>
          </div>
          <br>
      @endif
      @if ($place->get('blocs->presentation->donnees->acteurs_prives') || isset($edit))
          <div>
            <h5>LES ACTEURS PRIVÉS : </h5>
            <span class="is-block is-size-6">
              {{ $place->get('blocs->presentation->donnees->acteurs_prives') }}
              @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->acteurs_prives','id_section'=>'presentation','type' => 'text','titre'=>"Modifier les acteurs privés",'description'=>"Les acteurs privés partenaires ou soutien du projet"])
            </span>
          </div>
          <br>
      @endif
        <div>
          <h5>NATURE DES PARTENARIATS :</h5>
          <div class="is-size-6">
            @if($place->get('blocs->presentation->donnees->natures_partenariats->public') || isset($edit))
              <div> Publics : <span class="font-color-theme">
                  @foreach($place->get('blocs->presentation->donnees->natures_partenariats->public') as $nature)
                    {{ $nature }}@if(! $loop->last), @endif
                  @endforeach
                </span>
                @include('components.modals.modalEdition',['chemin'=> 'blocs->presentation->donnees->natures_partenariats->public','id_section'=>'presentation','type' => 'text','titre'=>"Modifier la nature des partenariats",'description'=>'Nature du soutien apporté par les acteurs publics partenaires du projet(économique, en nature ou autre)'])
              </div>
            @endif
            @if($place->get('blocs->presentation->donnees->natures_partenariats->prive') || isset($edit))
              <div> Privés : <span class="font-color-theme">
                @foreach($place->get('blocs->presentation->donnees->natures_partenariats->prive') as $nature)
                  {{ $nature}}@if(! $loop->last), @endif
                @endforeach
                </span>
                @include('components.modals.modalEdition',['chemin'=> 'blocs->presentation->donnees->natures_partenariats->prive','id_section'=>'presentation','type' => 'text','titre'=>"Modifier la nature des partenariats",'description'=>'Nature du soutien apporté par les acteurs privés partenaires du projet(économique, en nature ou autre)'])
              </div>
            @endif
          </div>
        </div>

    </div>
  </div>
</div>
