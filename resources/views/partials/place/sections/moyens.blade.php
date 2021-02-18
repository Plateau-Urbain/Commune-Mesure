<h2 class="ribbon-banner title is-5">Les moyens</h2>

<div class="field has-text-centered">
  @include('components.modals.modalEdition',['chemin'=>'data->finance->investissement'])<label class="is-size-5"for="switchRoundedSuccess" id="label_investissement">Investissement</label>
  <input id="switchRoundedSuccess" type="checkbox" name="switchRoundedSuccess" class="switch is-rounded is-success" checked="checked">
  <label class="is-size-5" for="switchRoundedSuccess" id="label_fonctionnement">Fonctionnement</label>
  @include('components.modals.modalEdition',['chemin'=>'data->finance->fonctionnement'])
</div>

<canvas id="financement-budget-doughnut" ></canvas>

<h3 class="no-border is-size-4 has-text-centered mt-6">Humains</h3>

<div class="columns">
  <div class="column is-3 is-offset-2">
    <span class="title is-1">{{$place->data->compare->moyens->etp->nombre}}</span><br /><span class="title is-5">ETP </span> @include('components.modals.modalEdition',['chemin'=>'data->compare->moyens->etp->nombre'])
  </div>
  <div class="column is-5 my-3" style="overflow-y: hidden; max-height: 200px;">
    @if($place->data->compare->moyens->etp->nombre >= 10)
      {{-- fix pour le cas spécial 10 --}}
      @if($place->data->compare->moyens->etp->nombre == 10)
        @svg('assets/images/body.svg', 'tiny narrow')<span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endif

      @for($i = 0; $i < $place->data->compare->moyens->etp->nombre - 10; $i = $i+10)
        @svg('assets/images/body.svg', 'tiny narrow')<span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endfor

      @if ($place->data->compare->moyens->etp->nombre % 10 == 0)
        @svg('assets/images/body.svg', 'tiny narrow')
      @endif
    @endif
    @for($i = 0; $i < $place->data->compare->moyens->etp->nombre % 10; $i++)
      @svg('assets/images/body.svg', 'tiny narrow')
    @endfor
  </div>
</div>

<div class="columns">
  <div class="column is-3 is-offset-2">
    <span class="title is-1">{{$place->data->compare->moyens->benevole->nombre}}</span><br /><span class="title is-5"> Bénévoles</span>@include('components.modals.modalEdition',['chemin'=>'data->compare->moyens->benevole->nombre'])
  </div>
  <div class="column is-5 my-3" style="overflow-y: hidden; max-height: 200px;">
    @if($place->data->compare->moyens->benevole->nombre >= 10)
      {{-- fix pour le cas spécial 10 --}}
      @if($place->data->compare->moyens->benevole->nombre == 10)
        @svg('assets/images/body.svg', 'tiny narrow')<span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endif

      @for($i = 0; $i < $place->data->compare->moyens->benevole->nombre - 10; $i = $i+10)
        @svg('assets/images/body.svg', 'tiny narrow')<span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endfor

      @if ($place->data->compare->moyens->benevole->nombre % 10 == 0)
        @svg('assets/images/body.svg', 'tiny narrow')
      @endif
    @endif
    @for($i = 0; $i < $place->data->compare->moyens->benevole->nombre % 10; $i++)
      @svg('assets/images/body.svg', 'tiny narrow')
    @endfor
  </div>
</div>

