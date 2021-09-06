<h2 class="sous-banner sous-banner-composition is-5">LES MOYENS</h2>
<p class='description-section' style="width:40%"> Les moyens humains et financiers mis en oeuvre pour assurer le fonctionnement du lieu</p>

  <div class="field has-text-centered">
      @if((!$place->isEmptyInvestissement() && !isset($edit)) || isset($edit))
        <label class="is-size-5 label_moyens" for="switchRoundedSuccess" id="label_investissement" >Investissement</label>
        @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->investissement','id_section'=>'moyens','type'=>'number','titre'=>"Modifier l'investissement",'description'=>"Le budget initial nécessaire au financement du projet et à l'ouverture du lieu"])&nbsp; &nbsp;
      @endif
      @if((!$place->isEmptyInvestissement() && !$place->isEmptyFonctionnement()  && !isset($edit)) || isset($edit))
        <input id="switchRoundedSuccess" type="checkbox" name="switchRoundedSuccess" class="switch is-rounded is-success" checked="checked">
      @endif
      @if((!$place->isEmptyFonctionnement() && !isset($edit)) || isset($edit))
        <label class="is-size-5 label_moyens" for="switchRoundedSuccess" id="label_fonctionnement" >Fonctionnement</label>
        @include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->fonctionnement','id_section'=>'moyens','type'=>'number','titre'=>"Modifier le fonctionnement","description"=>"Le budget annuel de fonctionnement du projet"])
      @endif
  </div>
<canvas id="financement-budget-doughnut" ></canvas>

  @if(!empty($place->get('blocs->presentation->donnees->emplois directs')) && !isset($edit) || isset($edit))
    <div class="columns">
      <div class="column is-3 is-offset-2">
        <span class="title is-1">{{$place->get('blocs->presentation->donnees->emplois directs')}}</span><br /><span class="title is-5">
          @if ($place->get('blocs->presentation->donnees->emplois directs') > 1)
            Emplois directs
          @else
            Emploi direct
          @endif
        </span> @include('components.modals.modalEdition',['chemin'=>'blocs->presentation->donnees->emplois directs','id_section'=>'moyens','type'=>'number','titre'=>"Modifier le nombre d'emplois directs","description"=>"Nombre d'emplois directement créés par le lieu pour son fonctionnement"])
      </div>
      <div class="column is-5 my-3" style="overflow-y: hidden; max-height: 200px;">
        {{-- fix pour le cas spécial 10 --}}
        @if($place->get('blocs->presentation->donnees->emplois directs') == 10)
          <img class='icone-moyen' src='{{ url('/images/10personnes.png') }}'/>
        @endif
        @if($place->get('blocs->presentation->donnees->emplois directs') > 100)
          @for($i=0; $i< 10; $i++)
            <img class='icone-moyen' src='{{ url('/images/10personnes.png') }}'/>
          @endfor
          <img class='icone-moyen' src='{{ url('/images/personnes.png') }}'/>
        @endif
        @if($place->get('blocs->presentation->donnees->emplois directs') > 10 && $place->get('blocs->presentation->donnees->emplois directs') <= 100)
          @for($i = 0; $i < $place->get('blocs->presentation->donnees->emplois directs') - 10; $i = $i+10)
            <img class='icone-moyen' src='{{ url('/images/10personnes.png') }}'/>
          @endfor
          @if ($place->get('blocs->presentation->donnees->emplois directs') % 10 == 0)
          <img class='icone-moyen' src='{{ url('/images/10personnes.png') }}'/>
          @endif
          @for($i = 0; $i < $place->get('blocs->presentation->donnees->emplois directs') % 10; $i++)
            <img class='icone-moyen' src='{{ url('/images/1personne.png') }}' />
          @endfor
        @endif
        @if($place->get('blocs->presentation->donnees->emplois directs') < 10)
          @for($i = 0; $i < $place->get('blocs->presentation->donnees->emplois directs') % 10; $i++)
            <img class='icone-moyen' src='{{ url('/images/1personne.png') }}' />
          @endfor
        @endif

      </div>
    </div>
  @endif
  @if(!empty($place->get('blocs->moyens->donnees->benevoles')) && !isset($edit) || isset($edit))
    <div class="columns">
      <div class="column is-3 is-offset-2">
        <span class="title is-1">{{$place->get('blocs->moyens->donnees->benevoles')}}</span><br /><span class="title is-5">
          @if ($place->get('blocs->moyens->donnees->benevoles') > 1)
            Bénévoles
          @else
            Bénévole
          @endif
        </span>@include('components.modals.modalEdition',['chemin'=>'blocs->moyens->donnees->benevoles','id_section'=>'moyens','type'=>'number','titre'=>"Modifier le nombre de bénévoles","description" => " Le nombre de bénévoles permettant le fonctionnement du lieu "])
      </div>
      <div class="column is-5 my-3" style="overflow-y: hidden; max-height: 200px;">
        {{-- fix pour le cas spécial 10 --}}
        @if($place->get('blocs->moyens->donnees->benevoles') == 10)
          <img class='icone-moyen' src='{{ url('/images/10personnes.png') }}'/>
        @endif
        @if($place->get('blocs->moyens->donnees->benevoles') > 100)
          @for($i=0; $i< 10; $i++)
            <img class='icone-moyen' src='{{ url('/images/10personnes.png') }}'/>
          @endfor
          <img class='icone-moyen' src='{{ url('/images/personnes.png') }}'/>
        @endif
        @if($place->get('blocs->moyens->donnees->benevoles') > 10 && $place->get('blocs->moyens->donnees->benevoles') <= 100 )
          @for($i = 0; $i < $place->get('blocs->moyens->donnees->benevoles') - 10; $i = $i+10)
            <img class='icone-moyen' src='{{ url('/images/10personnes.png') }}'/>
          @endfor
          @if ($place->get('blocs->moyens->donnees->benevoles') % 10 == 0)
            <img class='icone-moyen' src='{{ url('/images/10personnes.png') }}'/>
          @endif
          @for($i = 0; $i < $place->get('blocs->moyens->donnees->benevoles') % 10; $i++)
            <img class='icone-moyen' src='{{ url('/images/1personne.png') }}' />
          @endfor
        @endif
        @if($place->get('blocs->moyens->donnees->benevoles') < 10)
          @for($i = 0; $i < $place->get('blocs->moyens->donnees->benevoles') % 10; $i++)
            <img class='icone-moyen' src='{{ url('/images/1personne.png') }}' />
          @endfor
        @endif
      </div>
    </div>
  @endif
