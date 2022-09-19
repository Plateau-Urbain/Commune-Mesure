<section class="fond-bleu p-5">
  <img class="image mx-auto" width="455px" src="{{ url('/images/Les_valeurs.png') }}">

  <div class="columns">
    <div class="column is-6 is-flex is-flex-direction-column is-justify-content-center is-align-items-end">
      <h5 class="mt-5 is-size-5 has-text-primary no-border is-uppercase">Gouvernance</h5>
      <p>
        partagée avec {{ $place->get('blocs->presentation->donnees->noms_occupants') }}
        @include('components.modals.modalEdition', ['chemin'=>'blocs->presentation->donnees->noms_occupants','id_section'=>'presentation','type' => 'text','titre'=>"Modifier la gouvernance partagée","description" =>"Les différentes structures impliquées en cas de gouvernance partagée du lieu "])
      </p>

      <h5 class="mt-5 is-size-5 has-text-primary no-border is-uppercase">Réseaux</h5>
      <p>
        Nom du réseau
      </p>

      @if ($place->get('blocs->presentation->donnees->acteurs_prives') || isset($edit))
        <h5 class="mt-5 is-size-5 has-text-primary no-border is-uppercase">Les acteurs privés</h5>
        <p>
          {{ $place->get('blocs->presentation->donnees->acteurs_prives') }}
          @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->acteurs_prives','id_section'=>'presentation','type' => 'text','titre'=>"Modifier les acteurs privés",'description'=>"Les acteurs privés partenaires ou soutien du projet"])
        </p>
      @endif

      @if($place->get('blocs->presentation->donnees->natures_partenariats->prive') || isset($edit))
        <h5 class="is-size-6">Nature des partenariats :</h5>
        @foreach($place->get('blocs->presentation->donnees->natures_partenariats->prive') as $nature)
          {{ $nature }}@if(! $loop->last), @endif
        @endforeach
        @include('components.modals.modalEdition',['chemin'=> 'blocs->presentation->donnees->natures_partenariats->prive','id_section'=>'presentation','type' => 'text','titre'=>"Modifier la nature des partenariats",'description'=>'Nature du soutien apporté par les acteurs privés partenaires du projet(économique, en nature ou autre)'])
      @endif
    </div>

    <div class="column is-6 is-flex is-flex-direction-column is-justify-content-space-between">
      <div>
        @if(!empty($place->get('blocs->moyens->donnees->benevoles')) && !isset($edit) || isset($edit))
          <span class="title is-1 has-text-primary">{{$place->get('blocs->moyens->donnees->benevoles')}}</span>
          <br />
          <span class="title is-5">
            @if ($place->get('blocs->moyens->donnees->benevoles') > 1)Bénévoles @else Bénévole @endif
            @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->benevoles','id_section'=>'moyens','type'=>'number','titre'=>"Modifier le nombre de bénévoles","description" => " Le nombre de bénévoles permettant le fonctionnement du lieu "])
          </span>
        @endif
      </div>

      <div>
        @if ($place->get('blocs->presentation->donnees->acteurs_publics') || isset($edit))
          <h5 class="mt-5 is-size-5 has-text-primary no-border is-uppercase">Les acteurs publics</h5>
          <p>
            {{ $place->get('blocs->presentation->donnees->acteurs_publics') }}
            @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->acteurs_publics','id_section'=>'presentation','type' => 'text','titre'=>"Modifier les acteurs publics",'description'=>"Les acteurs publics partenaires ou soutien du projet"])
          </p>
        @endif
        @if($place->get('blocs->presentation->donnees->natures_partenariats->public') || isset($edit))
          <h5 class="is-size-6">Nature des partenariats :</h5>
          @foreach($place->get('blocs->presentation->donnees->natures_partenariats->public') as $nature)
            {{ $nature }}@if(! $loop->last), @endif
          @endforeach
          @include('components.modals.modalEdition',['chemin'=> 'blocs->presentation->donnees->natures_partenariats->public','id_section'=>'presentation','type' => 'text','titre'=>"Modifier la nature des partenariats",'description'=>'Nature du soutien apporté par les acteurs publics partenaires du projet(économique, en nature ou autre)'])
        @endif
      </div>

    </div>

  </div>
</section>
