<h2 class="ribbon-banner title is-5">Les moyens</h2>

<div class="field has-text-centered">
  <label class="is-size-5"for="switchRoundedSuccess" id="label_investissement">Investissement</label>
  @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->investissement','type'=>'number','titre'=>"Modifier L'Investissement",'description'=>"Qui ont investi et combien ils ont investi pour votre lieu ?"])&nbsp; &nbsp;
  <input id="switchRoundedSuccess" type="checkbox" name="switchRoundedSuccess" class="switch is-rounded is-success" checked="checked">
  <label class="is-size-5" for="switchRoundedSuccess" id="label_fonctionnement">Fonctionnement</label>
  @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->fonctionnement','type'=>'number','titre'=>"Modifier Le fonctionnement"])
</div>

<canvas id="financement-budget-doughnut" ></canvas>

<h3 class="no-border is-size-4 has-text-centered mt-6">Humains</h3>

<div class="columns">
  <div class="column is-3 is-offset-2">
    <span class="title is-1">{{$place->get('blocs->presentation->donnees->etp')}}</span><br /><span class="title is-5">ETP </span> @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->etp','type'=>'number','titre'=>"Modifier Le nombre d'ETP"])
  </div>
  <div class="column is-5 my-3" style="overflow-y: hidden; max-height: 200px;">
    @if($place->get('blocs->presentation->donnees->etp') >= 10)
      {{-- fix pour le cas spécial 10 --}}
      @if($place->get('blocs->presentation->donnees->etp') == 10)
        @svg('assets/images/body.svg', 'tiny narrow')<span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endif

      @for($i = 0; $i < $place->get('blocs->presentation->donnees->etp') - 10; $i = $i+10)
        @svg('assets/images/body.svg', 'tiny narrow')<span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endfor

      @if ($place->get('blocs->presentation->donnees->etp') % 10 == 0)
        @svg('assets/images/body.svg', 'tiny narrow')
      @endif
    @endif
    @for($i = 0; $i < $place->get('blocs->presentation->donnees->etp') % 10; $i++)
      @svg('assets/images/body.svg', 'tiny narrow')
    @endfor
  </div>
</div>

<div class="columns">
  <div class="column is-3 is-offset-2">
    <span class="title is-1">{{$place->get('blocs->moyens->donnees->benevoles')}}</span><br /><span class="title is-5"> Bénévoles</span>@include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->benevoles','type'=>'number','titre'=>"Modifier Le nombre de bénévoles"])
  </div>
  <div class="column is-5 my-3" style="overflow-y: hidden; max-height: 200px;">
    @if($place->get('blocs->moyens->donnees->benevoles') >= 10)
      {{-- fix pour le cas spécial 10 --}}
      @if($place->get('blocs->moyens->donnees->benevoles') == 10)
        @svg('assets/images/body.svg', 'tiny narrow')<span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endif

      @for($i = 0; $i < $place->get('blocs->moyens->donnees->benevoles') - 10; $i = $i+10)
        @svg('assets/images/body.svg', 'tiny narrow')<span class="has-text-primary">&nbsp;&bull;&bull;&bull;</span>
      @endfor

      @if ($place->get('blocs->moyens->donnees->benevoles') % 10 == 0)
        @svg('assets/images/body.svg', 'tiny narrow')
      @endif
    @endif
    @for($i = 0; $i < $place->get('blocs->moyens->donnees->benevoles') % 10; $i++)
      @svg('assets/images/body.svg', 'tiny narrow')
    @endfor
  </div>
</div>
