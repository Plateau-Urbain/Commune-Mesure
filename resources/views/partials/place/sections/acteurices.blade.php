<section class="fond-bleu content-block">
  <img class="image mx-auto" width="455px" src="{{ url('/images/Les_valeurs.png') }}">
  <h4 class="title has-text-weight-normal is-uppercase no-border has-text-primary has-text-centered bg-fil">
    <span class="fond-bleu">Les acteur.ices</span>
  </h4>

  <div class="columns is-multiline">
    <div class="column is-8 is-offset-2">
      <div class="columns is-variable is-6">

        {{-- Colonne haut-gauche --}}
        <div class="column is-4 is-offset-2 is-flex is-flex-direction-column is-justify-content-center is-align-items-flex-end has-text-right">
          <h5 class="mt-5 is-size-5 has-text-primary no-border is-uppercase">Gouvernance</h5>
          <p>
            partagée avec {{ $place->get('blocs->presentation->donnees->noms_occupants') }}
            @include('components.modals.modalEdition', ['chemin'=>'blocs->presentation->donnees->noms_occupants','id_section'=>'presentation','type' => 'text','titre'=>"Modifier la gouvernance partagée","description" =>"Les différentes structures impliquées en cas de gouvernance partagée du lieu "])
          </p>

          @if ($place->get('blocs->presentation->donnees->reseaux') || isset($edit))
            <h5 class="mt-5 is-size-5 has-text-primary no-border is-uppercase">Réseaux</h5>
            <p>
              {{ $place->get('blocs->presentation->donnees->reseaux') }}
              @include('components.modals.modalEdition', ['chemin'=>'blocs->presentation->donnees->reseaux', 'id_section'=>'presentation', 'type' => 'text', 'titre' => "Modifier le réseau", 'description' => "Le ou les réseaux auxquels appartient le lieu."])
            </p>
          @endif
        </div>

        {{-- Colonne haut-droite --}}
        <div class="column is-4 is-flex is-justify-content-space-evenly is-align-items-center">
          @if(!empty($place->get('blocs->moyens->donnees->benevoles')) && !isset($edit) || isset($edit))
            <div>
              <span class="title is-1 has-text-primary font-renner-black">{{$place->get('blocs->moyens->donnees->benevoles')}}</span>
              <br />
              <span>
                @if ($place->get('blocs->moyens->donnees->benevoles') > 1)Bénévoles @else Bénévole @endif
                @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->benevoles','id_section'=>'moyens','type'=>'number','titre'=>"Modifier le nombre de bénévoles","description" => " Le nombre de bénévoles permettant le fonctionnement du lieu "])
              </span>
            </div>
          @endif

          @if(!empty($place->get('blocs->presentation->donnees->emplois directs')) && !isset($edit) || isset($edit))
            <div>
              <span class="title is-size-1 has-text-primary font-renner-black">
                {{ $place->get('blocs->presentation->donnees->emplois directs') }}
              </span>
              <br/>
              <span>
                {{ $place->get('blocs->presentation->donnees->emplois directs') > 1 ? 'Emplois directs' : 'Emploi direct' }}
                @include('components.modals.modalEdition', ['chemin' => 'blocs->presentation->donnees->emplois directs', 'id_section' => 'presentation', 'type' => 'decimal', 'titre' => "Modifier le nombre d'emplois directs", "description" => "Nombre d'emplois directement créés par le lieu pour son fonctionnement"])
              </span>
            </div>
          @endif
        </div>

      </div>
    </div>

    <div class="column is-8 is-offset-2">
      <div class="columns is-variable is-6">

        {{-- Colonne bas-gauche --}}
        <div class="column is-4 is-offset-2 is-flex is-flex-direction-column is-justify-content-center is-align-items-flex-end has-text-right">
          @if ($place->get('blocs->presentation->donnees->acteurs_prives') || isset($edit))
            <h5 class="mt-5 is-size-5 has-text-primary no-border is-uppercase">Les acteurs privés</h5>
            <p>
              {{ $place->get('blocs->presentation->donnees->acteurs_prives') }}
              @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->acteurs_prives','id_section'=>'presentation','type' => 'text','titre'=>"Modifier les acteurs privés",'description'=>"Les acteurs privés partenaires ou soutien du projet"])
            </p>
          @endif

          @if($place->get('blocs->presentation->donnees->natures_partenariats->prive') || isset($edit))
            <h5 class="mt-2 is-size-5">Nature des partenariats&nbsp;:</h5>
              <p>
              @foreach($place->get('blocs->presentation->donnees->natures_partenariats->prive') as $nature)
                {{ $nature }}@if(! $loop->last), @endif
              @endforeach
              </p>
            @include('components.modals.modalEdition',['chemin'=> 'blocs->presentation->donnees->natures_partenariats->prive','id_section'=>'presentation','type' => 'text','titre'=>"Modifier la nature des partenariats",'description'=>'Nature du soutien apporté par les acteurs privés partenaires du projet(économique, en nature ou autre)'])
          @endif
        </div>

        {{-- Colonne bas-droite --}}
        <div class="column is-4 is-flex is-flex-direction-column is-justify-content-space-between">
          <div>
            @if ($place->get('blocs->presentation->donnees->acteurs_publics') || isset($edit))
              <h5 class="mt-5 is-size-5 has-text-primary no-border is-uppercase">Les acteurs publics</h5>
              <p>
                {{ $place->get('blocs->presentation->donnees->acteurs_publics') }}
                @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->acteurs_publics','id_section'=>'presentation','type' => 'text','titre'=>"Modifier les acteurs publics",'description'=>"Les acteurs publics partenaires ou soutien du projet"])
              </p>
            @endif
            @if($place->get('blocs->presentation->donnees->natures_partenariats->public') || isset($edit))
              <h5 class="mt-2 is-size-5">Nature des partenariats&nbsp;:</h5>
              <p>
                @foreach($place->get('blocs->presentation->donnees->natures_partenariats->public') as $nature)
                  {{ $nature }}@if(! $loop->last), @endif
                @endforeach
              </p>
              @include('components.modals.modalEdition',['chemin'=> 'blocs->presentation->donnees->natures_partenariats->public','id_section'=>'presentation','type' => 'text','titre'=>"Modifier la nature des partenariats",'description'=>'Nature du soutien apporté par les acteurs publics partenaires du projet(économique, en nature ou autre)'])
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
