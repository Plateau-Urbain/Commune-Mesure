@extends('layout')

@section('head_css')
    @parent
@endsection

@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js" integrity="sha512-FHsFVKQ/T1KWJDGSbrUhTJyS1ph3eRrxI228ND0EGaEp6v4a/vGwPWd3Dtd/+9cI7ccofZvl/wulICEurHN1pg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.5/d3.layout.cloud.js" integrity="sha512-UWEnsxiF3PBLuxBEFjpFEHQGZNLwWFqztm66Wok/kXsGSrcOS76CP3ovpEQmwlOmR2Co4iV5FmXrdb7YzP37SA==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.layout.forceAtlas2/supervisor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.layout.forceAtlas2/worker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edges.curvedArrow.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.extremities.def.js"></script>
    @include('components.place.chart-place')
    @include('components.place.map-insee-js')
    @include('components.place.sigma-cloud-words-js')
    @include('components.place.d3-cloud-words-js')
@endsection

@section('content')
<div class="columns is-gapless" id="container">
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
            <div class="section">
              <h2>Nos valeurs </h2>
              <div class="columns">
                <div class="column">
                  <div id="sigma" style="width:100%; height:20em;"></div>
              </div>
                <div class="column">
                  <div id="d3-cloud" style="width:100%; height:100%;"></div>
                </div>
              </div>
            </div>
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
              <div class="section">
                <div class="">
                    <h5 class="title is-5 has-text-centered">Financement</h5>
                    <canvas id="financement-doughnut" width="50px" height="50px"></canvas>
                </div>
              </div>
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
                  @endphp

                  <div class="Progress-item is-inline-block"
                  style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{1}->color }}; border-radius: 1em 0 0 1em;"
                  data-tooltip="{{ $place->data->composition->{1}->title }} : {{ number_format(number_format($quantity,1)*100, 2) }}%"></div>
                  @php ($quantity = $place->data->composition->{2}->nombre/$place->data->composition->{0}->nombre)
                  @endphp

                  <div class="Progress-item is-inline-block"
                  style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{2}->color }};"
                  data-tooltip="{{ $place->data->composition->{2}->title }} : {{ number_format(number_format($quantity,1)*100, 2) }}%"></div>
                  @php ($quantity = $place->data->composition->{3}->nombre/$place->data->composition->{0}->nombre)
                  @endphp

                  <div class="Progress-item is-inline-block"
                  style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{3}->color }};"
                  data-tooltip="{{ $place->data->composition->{3}->title }} :{{ number_format(number_format($quantity,1)*100, 2) }}%"></div>
                  @php ($quantity = $place->data->composition->{4}->nombre/$place->data->composition->{0}->nombre)
                  @endphp
                  <div class="Progress-item is-inline-block"
                  style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{4}->color }}; border-radius: 0 1em 1em 0;"
                  data-tooltip="{{ $place->data->composition->{4}->title }} :{{ number_format(number_format($quantity,1)*100, 2) }}%"></div>
                </div>
                <div class="columns mt-6">
                  <div class="column is-one-fifth">
                    <div class="caption-block">
                      <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:{{ $place->data->composition->{1}->color }};"></div>
                      <p class="is-inline-block">{{ $place->data->composition->{1}->title }}</p>
                    </div>
                    <div class="caption-block">
                      <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:{{ $place->data->composition->{2}->color }};"></div>
                      <p class="is-inline-block">{{ $place->data->composition->{2}->title }}</p>
                    </div>
                    <div class="caption-block">
                      <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:{{ $place->data->composition->{3}->color }};"></div>
                      <p class="is-inline-block">{{ $place->data->composition->{3}->title }}</p>
                    </div>
                    <div class="caption-block">
                      <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:{{ $place->data->composition->{4}->color }};"></div>
                      <p class="is-inline-block">{{ $place->data->composition->{4}->title }}</p>
                    </div>
                  </div>
                  <div class="column is-7">
                    <div class="columns is-multiline">
                      @foreach($place->data->composition as $composition)
                        @if(property_exists($composition, 'title'))
                        @php $quantity = number_format($composition->nombre/$place->data->composition->{0}->nombre, 1);
                        $percent= $quantity * 100;
                        @endphp
                          @for ($i = 0; $i < 500*($quantity); $i++)
                            <div class="">
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

        <section class="section anchor" id="donnees-insee">
          <h3 class="title is-3">Les données INSEE</h3>
          <div class="section">
            <div class="mb-5">
              <label>Choississez un découpage géographique: </label>
              <div class="select">
                <select id="selectGeo">
                  <option value="region">Région</option>
                  <option value="departement">Département</option>
                  <option value="commune">Commune</option>
                  <option value="iris" selected="selected">Iris</option>
                </select>
              </div>
            </div>
            <div class="columns card is-rounded">
              <div class="column" style="width: 100%;height: 30em; z-index:1">
                <div id="map-insee"></div>
              </div>
              <div class="column is-7">
                <div class="columns">
                  <div class="column">
                    <div class="mt-2">
                      <h4>Actifs</h4>
                      <div class="" style="width:100%">
                        <div class="actifBar myBar is-inline-block" style="background-color:#9be500;border-radius: 1em 0 0 1em;"></div><div class="actifBar myBar is-inline-block"
                         style="background-color:#005476; border-radius:0;">
                        </div><div class="actifBar myBar is-inline-block"
                        style="background-color:#650065;border-radius:0;"></div><div class="actifBar myBar is-inline-block"
                        style="background-color:#0392cf;border-radius:0;"></div><div class="actifBar myBar is-inline-block"
                        style="background-color:#ffa500; border-radius: 0 1em 1em 0;"></div>
                      </div>
                      <div class="mt-2">
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                      </div>
                    </div>
                    <div class="mt-2">
                      <h4>Catégories socioprofessionnelles</h4>
                      <div class="" style="width:100%">
                        <div class="cspBar myBar is-inline-block"
                        style="background-color: #3354ed; border-radius: 1em 0 0 1em;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#33a9ff;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#cc0001;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#ffaa01;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#ffff00;color: black; border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#d01975;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#78b385;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#000000;border-radius: 0 1em 1em 0;"></div>
                      </div>
                      <div class="mt-2">
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                      </div>
                    </div>
                    <div class="mt-2">
                      <h4>Immobiliers</h4>
                      <div class="" style="width:100%">
                        <div class="logementBar myBar is-inline-block"
                        style="background-color:#2bdcb2;border-radius: 1em 0 0 1em;"></div><div class="logementBar myBar is-inline-block"
                        style="background-color:#275843;border-radius:0;">
                        </div><div class="logementBar myBar is-inline-block"
                        style="background-color:#0038ff;border-radius: 0 1em 1em 0;"></div>
                      </div>
                      <div class="mt-2">
                        <div class="caption-block is-inline-block">
                          <div class="logementCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="logementTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="logementCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="logementTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="logementCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="logementTitle is-inline-block"></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
</div>
@endsection
