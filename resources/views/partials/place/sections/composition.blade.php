<h2 class="sous-banner sous-banner-composition is-5 has-text-centered">LA COMPOSITION</h2>
<p class='description-section'>Nombre et nature des structures ayant leurs locaux ou exerçant leur activité au sein du lieu</p>
<div class="field has-text-centered">
  <label class="is-size-5" style="font-weight: bold;" >Type de structures participant au projet</label>
  @include('components.modals.modalEdition',['chemin'=>'blocs->composition->donnees->type','id_section'=>'composition','type'=>'number','titre'=>"Modifier les types de structures",'description'=>"Quelle est la nature juridique des structures présentes au sein du lieu ? (par ex. entreprise, association, artistes etc.)"])
</div>
<canvas id="composition-chart-doughnut" ></canvas>


@if(!empty($place->get('blocs->composition->donnees->structures_crees')) && !isset($edit) || isset($edit))
  <div class="columns">
    <div class="column is-offset-2 is-3">
      <span class="title is-1">{{ $place->get('blocs->composition->donnees->structures_crees') }}</span> <br />
      <span class="title is-5">
        @if ($place->get('blocs->composition->donnees->structures_crees') > 1)
          structures créées
        @else
          structure créée
        @endif
        @include('components.modals.modalEdition',['chemin'=>'blocs->composition->donnees->structures_crees','id_section'=>'composition','type' => 'number','titre'=>"Modifier le nombre de structures créées","description" =>"Le nombre de structures qui ont été créées au sein du lieu ou dont la création a été permise par le lieu"])
      </span>
    </div>

    <div class="column is-5 my-3" style="overflow-y: auto; ">
      @if( $place->get('blocs->composition->donnees->structures_crees') <= 50)
        @for ($i = 0; $i < $place->get('blocs->composition->donnees->structures_crees'); $i++)
          <img class='icone-moyen' src='{{ url('/images/structure.png') }}'/>
        @endfor
      @endif
      @if( $place->get('blocs->composition->donnees->structures_crees') > 50)
        @for ($i = 0; $i < 50; $i++)
          <img class='icone-moyen' src='{{ url('/images/structure.png') }}'/>
        @endfor
          <span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endif
    </div>
  </div>
@endif
