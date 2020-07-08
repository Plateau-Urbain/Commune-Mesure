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
                <div class="columns is-centered">
                    @foreach ($place->badges as $badge)
                        <div class="column is-narrow">
                            <figure class="image is-128x128">
                                <img class="is-rounded" src="https://dummyimage.com/128x128/000/fff" alt="images/badges/{{ $badge }}.png" />
                            </figure>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="section">
                <div class="columns">
                    <div class="column is-one-third has-text-centered">
                        @foreach ($place->photos as $photo)
                            <img src="/images/{{ $photo }}" {{ getimagesize("images/$photo")[3] }}/>
                        @endforeach
                    </div>
                    <div class="column content">{!! $place->description !!}</div>
                </div>
            </section>
        </div>
        <section class="section">
            <div class="level">
                <div class="level-item has-text-centered">
                    <div>
                        <p class="heading">Entreprises</p>
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

        <div id="indicateurs" class="anchor">
            <section class="section">
                @include('components.place.survey')
            </section>

            <section class="section">
              <h3 class="title is-3">Indicateurs</h3>
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
          <h3 class="title is-3">Exemples de graph</h3>
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
