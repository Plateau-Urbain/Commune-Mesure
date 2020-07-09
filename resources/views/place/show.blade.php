@extends('layout')

@section('head_css')
    @parent
@endsection

@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    @include('components.place.chart-place')
    @include('components.place.survey-js')
@endsection

@section('content')
<div class="columns is-gapless">
    <div class="column is-2">
        @include('components.place-menu')
        {{-- @include('components.place.info-box') --}}
    </div>
    <div class="column">
        <div id="presentation" class="hero is-large anchor">
            <section class="section">
                <h1 class="title is-1 has-text-centered">{{ $place->name }}</h1>
                <div class="has-text-centered"><span class="has-text-grey-light">Tags :
                    @foreach ($place->tags as $tag)
                        <a class="tag is-white" href="/tag/{{ $tag }}" title="{{ $tag }}">{{ $tag }}</a>
                    @endforeach
                    ⋅ Web : <a class='tag' href="//example.com">{{ $place->name }}</a>
                </span></div>
            </section>

            <section class="section">
                <h5 class="title is-5 has-text-centered no-border">Badges</h5>
                <div class="columns is-centered">
                    <div class="tags are-large">
                        @foreach ($place->badges as $badge)
                            {{-- <div class="column is-narrow"> --}}
                            {{--     <figure class="image is-128x128"> --}}
                            {{--         <img class="is-rounded" src="https://dummyimage.com/128x128/000/fff" alt="images/badges/{{ $badge }}.png" /> --}}
                            {{--     </figure> --}}
                            {{-- </div> --}}
                            <span class="tag is-primary">{{ $badge }}</span>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
        <section class="section">
            <div class="level">
                <div class="level-item has-text-centered">
                    <div>
                        <p class="heading">Structures hébergées</p>
                        <p class="title is-1 animate-value" data-total="53" >53</p>
                    </div>
                </div>

                <div class="level-item has-text-centered">
                    <div>
                        <p class="heading">Années d'existence</p>
                        <p class="title is-1 animate-value" data-total="3" >3</p>
                    </div>
                </div>

                <div class="level-item has-text-centered">
                    <div>
                        <p class="heading">Followers</p>
                        <p class="title is-1"><span class="animate-value" data-total="12">12</span>K</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section has-text-centered ">
            <h5 class="title is-5 has-text-centered no-border">La composition du lieu</h5>
              <div class="is-2">
                <div class="Progress">
                  <div class="Progress-item is-inline-block" style="width:12em; background-color:#e34c26; border-radius: 1em 0 0 1em;"></div>
                  <div class="Progress-item is-inline-block" style="width:10em; background-color:#4F5D95;"></div>
                  <div class="Progress-item is-inline-block" style="width:4em; background-color:#563d7c;"></div>
                  <div class="Progress-item is-inline-block" style="width:2em; background-color:#f1e05a; border-radius: 0 1em 1em 0;"></div>
                </div>
                <div class="column">
                    <div class="Progress-label is-inline-block" style="background-color:#e34c26;"></div>
                    <span>Startup <p class="heading is-inline-block">40%</p></span>
                    <div class="Progress-label is-inline-block" style="background-color:#4F5D95;"></div>
                    <span>Associations <p class="heading is-inline-block">39%</p></span>
                    <div class="Progress-label is-inline-block" style="background-color:#563d7c;"></div>
                    <span>Artistes <p class="heading is-inline-block">15%</p></span>
                    <div class="Progress-label is-inline-block" style="background-color:#f1e05a;"></div>
                    <span>Autres <p class="heading is-inline-block">6%</p></span>
                </div>
              </div>
        </section>
        <section>
          <h5 class="title is-5 has-text-centered">Modèle économique</h5>
          <div class="columns is-flex is-vcentered is-centered">
            <div class="column">
              <div id="budget-value-illustration">
                <figure class="image">
                  <img  src="/images/budget_value.svg" >
                </figure>
                <div class="" id="description-illustration-detail">
                    <p><strong>{{ $place->name }} c'est quoi ?</strong></p>
                    <p class="fontSize1em">{{ $place->description }}</p>

                </div>
              </div>
            </div>
            <div class="column is-one-fifth">
              <div class="budget">
                <figure class="image is20em">
                  <img  src="/images/building.svg" >
                </figure>
                <div class="very-small" id="budget-year">Budget</div>
                <div class="very-small font-color-theme" id="budget-value">
                  <p>Annuel: {{ '100K ' }}€</p>
                  <p>Total: {{ '150K' }} €</p>
                </div>
                <div class="" id="actor">Les acteurs</div>
              </div>
            </div>
            <div class="column">
              <div id="actor-illustration">
                <figure class="image">
                  <img  src="/images/budget_value.svg" >
                </figure>
                <div class="content" id="actor-illustration-detail">
                  <ul>
                    <li>
                      <strong>Les acteurs publics</strong>
                      <ul>
                        <li>Marie de Paris</li>
                        <li>Region IDF</li>
                      </ul>
                    </li>
                    <br/>
                    <li class="fontSize1em">
                      <strong>Les acteurs privés</strong>
                      <ul>
                        <li>CIVA</li>
                        <li>Renault</li>
                      </ul>
                    </li>
                  <ul>
                </div>
              </div>
            </div>
          </div>
          <section class="section">
            <div class="column is-3 ">
                <h5 class="title is-5 has-text-centered">Financement</h5>
                <canvas id="financement-doughnut" width="50px" height="50px"></canvas>
            </div>
          </section>
        </section>
        <div id="indicateurs" class="anchor">
            <section class="section" id="indicateurs-martin">
              <h3 class="title is-3">Les indicateurs de Martin</h3>
              <h5 class="title is-5 has-text-centered">Indicateurs sociaux</h5>
              <div class="tabs is-small" data-tab-group="resilience">
                <ul>
                  <li class="is-active">
                    <a href="#charts">
                      <span class="icon is-small"><i class="fas fa-chart-line" aria-hidden="true"></i></span>
                      <span>Graphiques</span>
                    </a>
                  </li>
                  <li>
                    <a href="#raw">
                      <span class="icon is-small"><i class="fas fa-table" aria-hidden="true"></i></span>
                      <span>Données</span>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="tabs-content" data-tab-group="resilience">
                <div class="tab is-active" data-tab="charts">
                  @foreach($place->data->resilience as $resilience)
                      <p>{{ $resilience->title }} : {{ ($resilience->city / $resilience->total)*100 }}%</p>
                      <progress class="progress is-primary" value="{{ $resilience->city }}" max="{{ $resilience->total }}">{{ ($resilience->city / $resilience->total)*100 }}%</progress>
                  @endforeach
                </div>

                <div class="tab" data-tab="raw">
                  <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                     <thead>
                      <tr>
                        @foreach($place->data->resilience->job as $key => $value)
                          <th>{{ $key }}</th>
                          @endforeach
                      </tr>
                    </thead>
                    </tbody>
                      @foreach($place->data->resilience as $key => $resilience)
                        <tr>
                            <th scope="row">{{ $resilience->title }}</th>
                            @foreach($resilience as $key => $value)
                            @if($resilience->title !== $value)
                              <td>{{ $value }}</td>
                            @endif
                            @endforeach
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
        </div>

        <section class="section">
            <h5 class="title is-5 has-text-centered">Répartition de la population</h5>
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
            <h5 class="title is-5 has-text-centered">Répartition de l'emploi par sexe</h5>
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


        <section class="section anchors" id="indicateurs-approche">
          <h3 class="title is-3">Les indicateurs d'Approche</h3>
          <h5 class="title is-5 has-text-centered">Modalités d'occupation</h5>
          <div class="columns is-flex is-vcentered is-centered">
            <div class="column is-one-third">
              <div class="location-home">
                @svg('../public/images/location_home.svg')
               <div class="" id="owner">Propriétaire</div>
               <div class="" id="contract">Contrat</div>
              </div>
            </div>
            <div class="column">
              <div class="" id="illustration-contract">
                @foreach($sentences->groups as $key => $group)
                  @php ($string = "") @endphp
                  @php ($nb = 2) @endphp
                  <div class="">
                  @foreach($group as $keygroup => $question)
                    @if($keygroup !== "title")
                      @php ($answer = $place->data->survey->groups->{"$key"}->{"$keygroup"}->answer) @endphp
                      @if(!empty($question->answer->{$answer}->illustration))
                        @php ($string =$string.' '.$question->answer->{$answer}->string) @endphp
                        @if($nb > 2 && $nb <= count((array)$group))
                          <figure class=" is-inline-block image is5em">
                              <img  src="/images/arrow.svg" >
                          </figure>
                        @endif
                        @php ($nb +=1) @endphp
                        <figure class=" is-inline-block image is-128x128" title="{{ $question->question }}">
                            <img  src="{{ '/images/'.$question->answer->{$answer}->illustration }}" >
                        </figure>

                      @endif
                    @endif
                  @endforeach
                  </div>
                  <p class="subtitle">{{ sprintf($string, $place->name) }}</p>
                @endforeach
              </div>
            </div>
          </div>

          <h5 class="title is-5 has-text-centered">Services</h5>
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

        <section class="section anchor" id="donnees-insee">
          <h3 class="title is-3">Les données INSEE</h3>
          <h5 class="title is-5 has-text-centered">Répartition H/F</h5>
          <div class="tabs is-small" data-tab-group="population">
            <ul>
              <li class="is-active">
                <a href="#charts">
                  <span class="icon is-small"><i class="fas fa-chart-line" aria-hidden="true"></i></span>
                  <span>Graphiques</span>
                </a>
              </li>
              <li>
                <a href="#raw">
                  <span class="icon is-small"><i class="fas fa-table" aria-hidden="true"></i></span>
                  <span>Données</span>
                </a>
              </li>
            </ul>
          </div>

          <div class="columns is-multiline">
            <div class="column is-half ">
              <div class="tabs-content" data-tab-group="population">
                <div class="tab is-active" data-tab="charts">
                  <canvas id="chart-pop" height=380 width=760></canvas>
                </div>
                <div class="tab" data-tab="raw">
                  <pre>@json($place->data->population, JSON_PRETTY_PRINT)</pre>
                </div>
              </div>
            </div> {{-- Repartition H/F --}}
            <div class="column is-half">
              <canvas id="chart-pop-bar"></canvas>
            </div>
            <div class="column is-12"><h5 class="title is-5 has-text-centered">Répartition des actifs</h5></div>
            <div class="column is-half">
              <canvas id="chart-activities"></canvas>
            </div>
            <div class="column is-half">
              <canvas id="chart-activities2"></canvas>
            </div>
            <div class="column is-12"><h5 class="title is-5 has-text-centered">Logements</h5></div>
            <div class="column is-4 is-offset-4">
                <canvas id="chart-logement-radar"></canvas>
            </div>
          </div>
        </section>

        <section class="section">
          <h3 class="title is-3">Autres exemples de graph</h3>
          <div class="columns">
            <div class="column has-text-centered">
              <div id="chart-rough-logement-barh"></div>
            </div>
            <div class="column has-text-centered">
              <div id="chart-rough-logement-doughnut"></div>
            </div>
          </div>
        </section>
        <section class="section">
          <div class="column has-text-centered">
            <div id="chart-rough-logement-scatter"></div>
          </div>
        </section>
    </div>
</div>
@endsection
