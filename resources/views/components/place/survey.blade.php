<br/>
<h2 class="title">{{ "Modalités d'occupation" }}</h2>
<div class="columns is-flex is-vcentered is-centered">
  <div class="column">
    <div class="location-home">
      @svg('../public/images/location_home.svg')
     <div class="" id="owner">Propriétaire</div>
     <div class="" id="contract">Contrat</div>
    </div>
  </div>
  <div class="column">
    <div class="" id="illustration-contract">

      @foreach($sentences->groups as $key => $group)
      @php ($string = "")
      @php ($nb = 2)
        <div class="">
        @foreach($group as $keygroup => $question)
          @if($keygroup !== "title")
          @php ($answer = $place->data->survey->groups->{"$key"}->{"$keygroup"}->answer)
            @if(!empty($question->answer->{$answer}->illustration))
              @php ($string =$string.' '.$question->answer->{$answer}->string)
              @if($nb > 2 && $nb != count((array)$group))
                <figure class=" is-inline-block image is5em">
                    <img  src="{{ url('/images/arrow.svg') }}" >
                </figure>
              @endif
              <figure class=" is-inline-block image is-64x64" title="{{ $question->question }}">
                  <img  src="{{ url('/images/'.$question->answer->{$answer}->illustration) }}" >
              </figure>
              @php ($nb = $nb + 1)
            @endif
          @endif
        @endforeach
        </div>
        <p class="subtitle">{{ sprintf($string, $place->name) }}</p>
      @endforeach
    </div>
  </div>
</div>
<br/>
<h2 class="title">{{ "Modèle économique" }}</h2>
<div class="columns is-flex is-vcentered is-centered">
  <div class="column">
    <div id="budget-value-illustration">
      <figure class="image">
        <img  src="{{ url('/images/budget_value.svg') }}" >
      </figure>
      <div class="" id="budget-value-illustration-detail">
          <p class="fontSize1em"><strong>Un budget annuel de:</strong></p>
          <p class="fontSize1em"><strong>{{ "120K €" }}</strong></p>
          <br/>
          <p class="fontSize1em"><strong>Un budget total de:</strong></p>
          <p class="fontSize1em"><strong>{{ "150K €" }}</strong></p>
      </div>
    </div>
  </div>
  <div class="column is-one-fifth has-text-centered">
    <div class="budget">
      <figure class="image is20em">
        <img  src="{{ url('/images/budget.svg') }}" >
      </figure>
      <div class="" id="budget-year">Budget annuel</div>
      <div class="" id="budget-fund">Origines des fonds</div>
      <div class="" id="budget-total">Budget total</div>
    </div>
  </div>
  <div class="column">
    <div id="budget-fund-illustration">
      <figure class="image">
        <img  src="{{ url('/images/budget_value.svg') }}" >
      </figure>
      <div class="" id="budget-fund-illustration-detail">
        <ul class="menu-list">
          <li class="fontSize1em"><strong>Fonds public</strong></li>
          <br/>
          <li class="fontSize1em"><strong>Fonds privé</strong></li>
        <ul>
      </div>
    </div>
  </div>
</div>

<section class="section">
    <div class="columns is-vcentered">
        <div class="column has-text-centered">
            <h2 class="title is-2 no-border">39%</h2>
            <h4 class="subtitle is-4">de femmes</h4>
        </div>
        <div class="column has-text-centered">
            <div class="columns is-multiline">
            @for ($i = 0; $i < 4; $i++)
                <div class="column is-one-fifth">
                    @svg('assets/images/female.svg', 'very-small')
                </div>
            @endfor
            @for ($i = 0; $i < 6; $i++)
                <div class="column is-one-fifth">
                    @svg('assets/images/male.svg', 'very-small')
                </div>
            @endfor
            </div>
        </div>
        <div class="column has-text-centered">
            <h2 class="title is-2 no-border">61%</h2>
            <h4 class="subtitle is-4">d'hommes</h4>
        </div>
    </div>
</section>

<section class="section">
    <div class="columns is-vcentered">
        <div class="column is-2 has-text-centered is-offset-3">
            <h2 class="title is-2 no-border">84%</h2>
            <h4 class="subtitle is-4">d'emploi</h4>
        </div>
        <div class="column is-2 has-text-centered is-narrow">
            <div class="column">
                @svg('assets/images/body.svg', 'small')
            </div>
        </div>
        <div class="column is-2 has-text-centered">
            <h2 class="title is-2 no-border">91%</h2>
            <h4 class="subtitle is-4">d'emploi</h4>
        </div>
    </div>
</section>

<section class="section">
    <div class="columns is-vcentered has-text-centered">
        <div class="column is-3 is-offset-2">
            @for($i = 100; $i > 0;)
                @for($j = 1; $j <= 10; $j++ && $i--)
                    <div class="squared
                    @if($i <= 48)
                        filled
                    @endif
                    "></div>
                @endfor
                <br>
            @endfor
            <h2 class="title is-2 no-border">48%</h2>
            <h4 class="subtitle is-4">de réinsertion</h4>
        </div>
        <div class="column is-3 is-offset-2">
            <canvas id="financement-doughnut" width="50px" height="50px"></canvas>
        </div>
    </div>
</section>

<section class="section">
    <div class="columns is-vcentered has-text-centered">
        <div class="column is-2 is-offset-3">
            <img id="img-left" src="/images/questionnaire/goal.svg">
            <p style="font-family: 'Renner Bold'">Occupant.e.s du site</p>
        </div>
        <div class="column is-2">
            <div>
                <img src="/images/questionnaire/arrow.svg">
            </div>
            <div>
                <p class="is-size-3" style="font-family: 'Renner Bold'">Conseils</p>
            </div>
            <div>
                <img src="/images/questionnaire/arrow.svg" style="transform: scaleY(-1) scaleX(-1);">
            </div>
        </div>
        <div class="column is-2">
            <img id="img-right" src="/images/questionnaire/new-start.svg">
            <p style="font-family: 'Renner Bold'">Chercheurs d'emplois</p>
        </div>
    </div>

    <div id="radio-listener" class="columns is-vcentered has-text-centered">
        <div class="column is-2 is-offset-3">
            <div class="control mt-2">
                <label class="radio"><input id="check-left" type="radio" name="left" checked data-img="goal" data-txt="Occupant.e.s du site">Occupant.e.s</label>
                <label class="radio"><input id="check-left" type="radio" name="left" data-img="acteurs" data-txt="Acteurs locaux">Acteurs</label>
            </div>
        </div>
        <div class="column is-2"></div>
        <div class="column is-2">
            <div class="control mt-2">
                <label class="radio"><input type="radio" name="right" checked data-img="new-start" data-txt="Chercheurs d'emplois">Chercheurs d'emplois</label>
                <label class="radio"><input type="radio" name="right" data-img="difficulties" data-txt="Public en difficultés">Publics en difficultés</label>
            </div>
        </div>
    </div>
</section>
