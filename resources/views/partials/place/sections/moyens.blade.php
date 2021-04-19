<h2 class="sous-banner sous-banner-composition is-5">LES MOYENS</h2>
  <div class="field has-text-centered">
      @if((!$place->isEmptyInvestissement() && !isset($edit)) || isset($edit))
        <label class="is-size-5 label_moyens" for="switchRoundedSuccess" id="label_investissement" >Investissement</label>
        @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->investissement','id_section'=>'section04','type'=>'number','titre'=>"Modifier l'investissement",'description'=>"Qui ont investi et combien ils ont investi pour votre lieu ?"])&nbsp; &nbsp;
      @endif
      @if((!$place->isEmptyInvestissement() && !$place->isEmptyFonctionnement()  && !isset($edit)) || isset($edit))
        <input id="switchRoundedSuccess" type="checkbox" name="switchRoundedSuccess" class="switch is-rounded is-success" checked="checked">
      @endif
      @if((!$place->isEmptyFonctionnement() && !isset($edit)) || isset($edit))
        <label class="is-size-5 label_moyens" for="switchRoundedSuccess" id="label_fonctionnement" >Fonctionnement</label>
        @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->fonctionnement','id_section'=>'section04','type'=>'number','titre'=>"Modifier le fonctionnement"])
      @endif
  </div>
<canvas id="financement-budget-doughnut" ></canvas>

@if(!empty($place->get('blocs->presentation->donnees->etp')) && !isset($edit) || !empty($place->get('blocs->moyens->donnees->benevoles')) && !isset($edit) || isset($edit) )
  <h3 class="no-border is-size-4 has-text-centered mt-6">Humains</h3>
  @if(!empty($place->get('blocs->presentation->donnees->etp')) && !isset($edit) || isset($edit))
    <div class="columns">
      <div class="column is-3 is-offset-2">
        <span class="title is-1">{{$place->get('blocs->presentation->donnees->etp')}}</span><br /><span class="title is-5">ETP </span> @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->etp','id_section'=>'section04','type'=>'number','titre'=>"Modifier le nombre d'ETP"])
      </div>
      <div class="column is-5 my-3" style="overflow-y: hidden; max-height: 200px;">
        {{-- fix pour le cas spécial 10 --}}
        @if($place->get('blocs->presentation->donnees->etp') == 10)
          <img class='icone-moyen' src='/images/10personnes.png'/>
        @endif
        @if($place->get('blocs->presentation->donnees->etp') > 100)
          @for($i=0; $i< 10; $i++)
            <img class='icone-moyen' src='/images/10personnes.png'/>
          @endfor
          <img class='icone-moyen' src='/images/personnes.png'/>
        @endif
        @if($place->get('blocs->presentation->donnees->etp') > 10 && $place->get('blocs->presentation->donnees->etp') <= 100)
          @for($i = 0; $i < $place->get('blocs->presentation->donnees->etp') - 10; $i = $i+10)
            <img class='icone-moyen' src='/images/10personnes.png'/>
          @endfor
          @if ($place->get('blocs->presentation->donnees->etp') % 10 == 0)
          <img class='icone-moyen' src='/images/10personnes.png'/>
          @endif
          @for($i = 0; $i < $place->get('blocs->presentation->donnees->etp') % 10; $i++)
            <img class='icone-moyen' src='/images/1personne.png' />
          @endfor
        @endif
        @if($place->get('blocs->presentation->donnees->etp') < 10)
          @for($i = 0; $i < $place->get('blocs->presentation->donnees->etp') % 10; $i++)
            <img class='icone-moyen' src='/images/1personne.png' />
          @endfor
        @endif

      </div>
    </div>
  @endif
  @if(!empty($place->get('blocs->moyens->donnees->benevoles')) && !isset($edit) || isset($edit))
    <div class="columns">
      <div class="column is-3 is-offset-2">
        <span class="title is-1">{{$place->get('blocs->moyens->donnees->benevoles')}}</span><br /><span class="title is-5"> Bénévoles</span>@include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->benevoles','id_section'=>'section04','type'=>'number','titre'=>"Modifier le nombre de bénévoles"])
      </div>
      <div class="column is-5 my-3" style="overflow-y: hidden; max-height: 200px;">
        {{-- fix pour le cas spécial 10 --}}
        @if($place->get('blocs->moyens->donnees->benevoles') == 10)
          <img class='icone-moyen' src='/images/10personnes.png'/>
        @endif
        @if($place->get('blocs->moyens->donnees->benevoles') > 100)
          @for($i=0; $i< 10; $i++)
            <img class='icone-moyen' src='/images/10personnes.png'/>
          @endfor
          <img class='icone-moyen' src='/images/personnes.png'/>
        @endif
        @if($place->get('blocs->moyens->donnees->benevoles') > 10 && $place->get('blocs->moyens->donnees->benevoles') <= 100 )
          @for($i = 0; $i < $place->get('blocs->moyens->donnees->benevoles') - 10; $i = $i+10)
            <img class='icone-moyen' src='/images/10personnes.png'/>
          @endfor
          @if ($place->get('blocs->moyens->donnees->benevoles') % 10 == 0)
            <img class='icone-moyen' src='/images/10personnes.png'/>
          @endif
          @for($i = 0; $i < $place->get('blocs->moyens->donnees->benevoles') % 10; $i++)
            <img class='icone-moyen' src='/images/1personne.png' />
          @endfor
        @endif
        @if($place->get('blocs->presentation->donnees->etp') < 10)
          @for($i = 0; $i < $place->get('blocs->moyens->donnees->benevoles') % 10; $i++)
            <img class='icone-moyen' src='/images/1personne.png' />
          @endfor
        @endif
      </div>
    </div>
  @endif
@endif
