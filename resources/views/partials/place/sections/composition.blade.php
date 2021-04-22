<h2 class="sous-banner sous-banner-composition is-5 has-text-centered">LA COMPOSITION</h2>
<div class="field has-text-centered">
  <label class="is-size-5" style="font-weight: bold;" >Type de structures présentes dans le projet</label>
  @include('components.modals.modalEdition',['chemin'=>'blocs->composition->donnees->type','id_section'=>'section04','type'=>'number','titre'=>"Modifier les types de structures",'description'=>"Quelles sont les types de structures et quelles sont leurs effectifs ?"])
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
        @include('components.modals.modalEdition',['chemin'=>'blocs->composition->donnees->structures_crees','id_section'=>'section04','type' => 'number','titre'=>"Modifier le nombre de structures créées"])
      </span>
    </div>

    <div class="column is-5 my-3" style="overflow-y: auto; ">
      @if( $place->get('blocs->composition->donnees->structures_crees') <= 50)
        @for ($i = 0; $i < $place->get('blocs->composition->donnees->structures_crees'); $i++)
          <img class='icone-moyen' src='/images/structure.png'/>
        @endfor
      @endif
      @if( $place->get('blocs->composition->donnees->structures_crees') > 50)
        @for ($i = 0; $i < 50; $i++)
          <img class='icone-moyen' src='/images/structure.png'/>
        @endfor
          <span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endif
    </div>
  </div>
@endif
