<h2 class="ribbon-banner title is-5 has-text-centered">La composition</h2>
<div class="field has-text-centered">
  <label class="is-size-5" style="font-weight: bold;" >Type de structures</label>
  @include('components.modals.modalEdition',['chemin'=>'data->finance->composition','titre'=>"Modifier Les types de structures",'description'=>"Quelles sont les types de structures et quelles sont leurs effectifs ?"])
</div>
<canvas id="composition-chart-doughnut" ></canvas>

<h3 class="no-border is-4 has-text-centered mt-6 is-size-4">Création</h3>
<div class="columns">
  <div class="column is-offset-2 is-3">
    <span class="title is-1">{{ $place->get('impact_economique->nombre_structures_crees') }}</span> <br />
    <span class="title is-5">
      @if ($place->get('impact_economique->nombre_structures_crees') > 1)
        structures créées
      @else
        structure créée
      @endif
      @include('components.modals.modalEdition',['chemin'=>'impact_economique->nombre_structures_crees','titre'=>"Modifier Le nombre de structures créées"])
    </span>
  </div>

  <div class="column is-5 my-3" style="overflow-y: auto; ">
    @for ($i = 0; $i < $place->get('impact_economique->nombre_structures_crees'); $i++)
      <span class="icon is-small mx-2">
        <span class="fa-stack fa-sm">
          <i class="fas fa-industry fa-stack-2x" style="color: #e85048"></i>
          <i class="fas fa-star fa-stack-1x" style="color: #FFDC00; padding-left:1.33em; margin-top:-15px"></i>
        </span>
      </span>
    @endfor
  </div>
</div>

