@extends('layout')

@section('head_css')
    @parent
@endsection

@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    @include('components.place.chart-place')
    @include('components.place.map-insee-js')
@endsection

@section('content')
<div class="columns is-gapless">
    <div class="column is-2">
        @include('components.place.place-menu')
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

        <section class="section has-text-centered ">
          <h5 class="title is-5 has-text-centered no-border">La composition du lieu</h5>
            <section class="section">
              <div class="has-text-centered">
                <div class="">
                  @php ($quantity = $place->data->composition->{1}->nombre/$place->data->composition->{0}->nombre)

                  <div class="Progress-item is-inline-block" style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{1}->color }}; border-radius: 1em 0 0 1em;"></div>
                  @php ($quantity = $place->data->composition->{2}->nombre/$place->data->composition->{0}->nombre)

                  <div class="Progress-item is-inline-block" style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{2}->color }};"></div>
                  @php ($quantity = $place->data->composition->{3}->nombre/$place->data->composition->{0}->nombre)

                  <div class="Progress-item is-inline-block" style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{3}->color }};"></div>
                  @php ($quantity = $place->data->composition->{4}->nombre/$place->data->composition->{0}->nombre)
                  <div class="Progress-item is-inline-block" style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{4}->color }}; border-radius: 0 1em 1em 0;"></div>
                </div>
                <div class="columns">
                  <div class="column is-half is-offset-one-quarter">
                    <div class="columns is-multiline mt-6">
                      @foreach($place->data->composition as $composition)
                        @if(property_exists($composition, 'title'))
                        @php ($quantity = number_format($composition->nombre/$place->data->composition->{0}->nombre, 1))
                        @php ($percent= $quantity * 100)
                          @for ($i = 0; $i < 30*($quantity); $i++)
                            <div class="column is-one-fifth">
                                <i class="fa {{ $composition->img }}" style="color:{{ $composition->color }};" data-toggle="tooltip" title="{{ $composition->title }} : {{ number_format($percent, 2) }}%"></i>
                            </div>
                          @endfor
                        @endif
                      @endforeach
                    </div>
                </div>
              </div>
            </div>
          </section>
        </section>
        <section>
          <h5 class="title is-5 has-text-centered">Modèle économique</h5>
          <div class="columns is-flex is-vcentered is-centered">
            <div class="column">
              <div id="budget-value-illustration">
                <figure class="image">
                  <img  src="/images/bloc_note.svg" >
                </figure>
                <div class="" id="description-illustration-detail">
                    <p><strong>{{ $place->name }} c'est quoi ?</strong></p>
                    <p class="fontSize1em">{{ $place->description }}</p>

                </div>
              </div>
            </div>
            <div class="column is-one-fifth">
              <div class="budget">
                <figure class="image is30em">
                  <img  src="/images/building_detail.svg" >
                </figure>
                <div class="very-small" id="occupant">{{ "150" }} occupants</div>
                <div class="very-small" id="budget-value">

                </div>
                <div class="" id="actor">Gouvernance partagée</div>
              </div>
            </div>
            <div class="column">
              <div id="actor-illustration">
                <figure class="image">
                  <img  src="/images/bloc_note.svg" >
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

        <section class="section anchor" id="donnees-insee">
          <h3 class="title is-3">Les données INSEE</h3>
          <div class="section">
            <div class="columns">
              <div class="column card is-rounded">
                <div>
                  <canvas id="bar-chart-horizontal" width="800" height="450"></canvas>
                </div>
                <div class="columns">
                  <div class="column">
                    <h4>Actifs</h4>
                    <div style="height:2em; width:40%; background-color:#0392cf;"></div>
                    <h4>Chômeurs</h4>
                    <div style="height:2em; width:25%; background-color:#f37736;"></div>
                    <h4>Autres</h4>
                    <div style="height:2em; width:35%; background-color:#ee4035;"></div>
                  </div>
                  <div class="column is-one-fifth">
                    <h4>Légende</h4>
                    <div class="">
                      <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:#0392cf;"></div>
                      <p class="is-inline-block">Actifs</p>
                    </div>
                    <div class="">
                      <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:#f37736;"></div>
                      <p class="is-inline-block">Étudiants</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="column" style="width: 100%;height: 30em;">
                <div id="map-insee"></div>
              </div>
            </div>
          </div>
          <div>
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
          </div>
        </section>
    </div>
</div>
@endsection
