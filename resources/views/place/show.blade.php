@extends('layout')

@section('title')
<h1 class="title header-title">
{{ $place->name }}
</h1>
<h2 class="subtitle">
    {{ $place->address->city }}
</h2>
@endsection

@section('head_css')
    @parent
@endsection

@section('script_js')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> {{-- Graphs insee --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> {{-- animate on scroll impact --}}
    <script>AOS.init();</script>
    <script src='https://d3js.org/d3.v4.min.js'></script> {{-- chart finance --}}
    @include('components.place.chart-place')
    @include('components.place.map-insee-js')
    @include('components.place.d3-doughnut-finance-js')
    @include('components.place.insee-chart-js')
    @include('components.place.value-bubbles')
@endsection

@section('content')
<div class="columns is-gapless" id="container">
    <div class="column is-2">
        @include('components.place.place-menu')
    </div>

    <div class="column">
        <div id="presentation" class="hero is-large anchor">
            <section>
              <h2 class="ribbon-banner is-5 has-text-centered">Présentation du lieu</h2>
              <div class="has-text-centered pt-2">
                <p><i class="fas fa-clock font-color-theme mr-1"></i>
                  <strong>Ouverture : </strong><span class="font-color-theme">En permanence</span>
                </p>
              </div>
              <div class="section pt-5" style="padding-bottom:0;">
                <div class="columns is-tablet">
                <div class="column">
                  <!-- Bloc note begin -->
                  <div class=" bloc-note">
                      <div class="header-bloc-note">
                        <figure class="image">
                          <img src="/images/bloc_noteAsset.png">
                        </figure>
                      </div>
                      <div class="bloc-note-body">
                        <div class="content">
                            <h2 class="has-text-centered">L'idée fondatrice</h2>
                            <p class="fontSize0-8em">{{ $place->description }}</p>
                        </div>
                      </div>
                  </div>
                  <!-- Bloc note end -->
                </div>
                <div class="column">
                  <div class="home-head">
                    <figure class="image">
                      <img src="/images/roofing.svg">
                    </figure>
                  </div>
                <div class="column home-body">
                    <div class="columns is-mobile">
                      <div class="column home-body-left">
                        <div class="window very-small">{{ $place->manager->occupants }} structures occupantes</div>
                        <div class="window very-small">La gouvernance partagée avec {{ $place->manager->name }}</div>
                        <div class="window very-small">Ouvert depuis {{ $place->ouverture}}</div>
                        <div class="window very-small">Surface de {{ $place->data->compare->moyens->superficie->nombre}}m<sup>2</sup></div>
                        <div class="window very-small">{{ $place->data->compare->moyens->etp->nombre}} ETP</div>

                        <div class="home-door">
                          <figure class="image">
                            <img src="/images/foot_home.svg">
                          </figure>
                        </div>
                      </div>
                      <div class="column is-one-third has-text-centered home-body-right">

                      <div class="">
                        <figure class="image">
                          <img src="/images/groupe_windows.svg">
                        </figure>
                      </div>
                      <div class="">
                        <figure class="image">
                          <img src="/images/groupe_windows.svg">
                        </figure>
                      </div>
                    </div>
                  </div>
                  <div class="home-foot"></div>
                </div>
              </div>
                <div class="column">
                  <!-- Bloc note begin -->
                  <div class="bloc-note">
                      <div class="header-bloc-note">
                        <figure class="image">
                          <img src="/images/bloc_noteAsset.png">
                        </figure>
                      </div>
                      <div class="bloc-note-body">
                        <div class="content">
                          @foreach($place->partners as $partner)
                            @if($partner->names)
                            <div>
                              <strong>Les acteurs {{ $partner->title }}s :</strong>
                              <span class="is-block is-size-7">
                                {{ $partner->names }}
                              </span>
                            </div>
                            @endif
                          @endforeach
                          @if($place->partners[0]->names || $place->partners[1]->names)
                          <div class="">
                            <strong class="">Nature des partenariats :</strong>
                            <div class="is-size-7">
                              @foreach($place->partners as $partner)
                              @if (count($partner->natures))
                              <div>{{ ucfirst($partner->title) }} : <span class="font-color-theme">
                                @foreach($partner->natures as $nature)
                                  {{ $nature }}@if(! $loop->last), @endif
                                @endforeach
                                </span>
                                @endif
                              </div>
                              @endforeach
                            </div>
                          </div>
                          @endif
                        </div>
                      </div>
                  </div>
                  <!-- Bloc note end -->
                </div>
              </div>
            </section>
          </div>
          <section>
            <div class="section" style="padding:0;">
              <div class="columns has-text-centered ">
                <div class="column">
                  <div class="has-text-centered">
                    <p class="mb-5">
                      <strong>Les differents publics : </strong>
                    </p>
                  </div>

                  <div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
                    @foreach($place->opening as $publics)
                    @foreach($publics->names as $public)
                    @if($public == 'Enfants')
                    <span class="is-block ml-3 public-icons has-tooltip-bottom" data-tooltip="Enfants"><i class="fa fa-child font-color-theme mr-1"></i></span>
                    @endif
                    @if($public == 'Étudiants')
                    <span class="is-inline-block ml-3 public-icons has-tooltip-bottom" data-tooltip="Étudiants"><i class="fa fa-user-graduate font-color-theme mr-1"></i></span>
                    @endif
                    @if($public == 'Famille')
                    <span class="is-block ml-3 public-icons has-tooltip-bottom" data-tooltip="Famille"><i class="fa fa-users font-color-theme mr-1"></i></span>
                    @endif
                    @endforeach
                    @endforeach
                  </div>
                </div>
                <div class="column">
                <div class="has-text-centered">
                  <p class="mb-5">
                    <strong>Accessibilité:</strong>
                  </p>
                </div>
                  <div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
                    @foreach($place->opening as $publics)
                    @foreach($publics->names as $public)
                    @if($public == 'Handicapés')
                    <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Fauteuils roulants"><i class="fa fa-wheelchair font-color-theme mr-1"></i></span>
                    @endif
                    @endforeach
                    @endforeach
                    <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Mal-voyants"><i class="fa fa-blind font-color-theme mr-1"></i></span>
                  </div>
                </div>
                <div class="column">
                  <div class="has-text-centered">
                  <p class="mb-5">
                    <strong>Moyens de transports accessibles:</strong>
                  </p>
                  </div>
                  <div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
                    <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Bus"><i class="fas fa-bus font-color-theme mr-1"></i></span>
                    <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Métro"><i class="fas fa-subway font-color-theme mr-1"></i></span>
                    <span class="ml-3 public-icons has-tooltip-bottom" data-tooltip="Voiture"><i class="fas fa-car font-color-theme mr-1"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <div>

            <section class="section" id="valeurs">
              <h2 class="ribbon-banner title is-5 has-text-centered" >Les valeurs</h2>
              <div class="columns">
                <div class="column has-text-centered">
                  <div id="value_container"></div>
                  <!-- <div id="sigma" style="width:100%; height:30em;"></div> -->
                  <!-- <center><iframe height="300" width="500" src="/graph/examples/graph.html"></iframe></center> -->
                </div>
              </div>
            </section>
            <section class="section" id="finances" >
                  <div class="columns">
                    <div class="column">
                      <h2 class="ribbon-banner title is-5">Les moyens</h2>
                      <div class="field has-text-centered">
                        <label class="is-size-5"for="switchRoundedSuccess" id="label_investissement">Investissement</label>
                        <input id="switchRoundedSuccess" type="checkbox" name="switchRoundedSuccess" class="switch is-rounded is-success" checked="checked">
                        <label class="is-size-5" for="switchRoundedSuccess" id="label_fonctionnement">Fonctionnement</label>
                      </div>
                      <canvas id="financement-budget-doughnut" ></canvas>
                      <h3 class="no-border is-size-4 has-text-centered mt-6">Humains</h3>
                        <div class="columns">
                          <div class="column is-3">
                              <span class="title is-1">{{$place->data->compare->moyens->etp->nombre}}</span><br /><span class="title is-5">ETP</span>
                          </div>
                          <div class="column my-3" style="overflow-y: hidden; max-height: 200px;">
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
                            <div class="column is-3">
                              <span class="title is-1">{{$place->data->compare->moyens->benevole->nombre}}</span><br /><span class="title is-5"> Bénévoles</span>
                            </div>
                            <div class="column my-3" style="overflow-y: hidden; max-height: 200px;">
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
                    </div>

                    <div class="column">
                        <h2 class="ribbon-banner title is-5 has-text-centered">La composition</h2>
                        <div class="field has-text-centered">
                            <label class="is-size-5" style="font-weight: bold;" >Type de structures</label>
                        </div>
                        <canvas id="composition-chart-doughnut" ></canvas>

                        <h3 class="no-border is-4 has-text-centered mt-6 is-size-4">Création</h3>
                        <div class="columns">
                            <div class="column is-4">
                                <span class="title is-1">{{ $place->impact_economique->nombre_structures_crees }}</span><br />
                                <span class="title is-5">
                                    @if ($place->impact_economique->nombre_structures_crees > 1)
                                        structures créées
                                    @else
                                        structure créée
                                    @endif
                                </span>
                            </div>

                            <div class="column" style="overflow-y: hidden; max-height: 200px;">
                                @for ($i = 0; $i < $place->impact_economique->nombre_structures_crees; $i++)
                                    <span class="icon is-large">
                                        <span class="fa-stack fa-lg">
                                            <i class="fas fa-industry fa-stack-2x" style="color: #e85048"></i>
                                            <i class="fas fa-star fa-stack-1x" style="color: #FFDC00; padding-left:1.33em; margin-top:-15px"></i>
                                        </span>
                                    </span>
                                @endfor
                            </div>
                        </div>
                    </div>
                  </div>
            </section>
          </div>
          @if($place->impact != [])
          <section class="section" id="impact-social">
              <h2 class="ribbon-banner title is-5 has-text-centered">L'impact social</h2>
              <div class="columns" style="margin-top: 100px;">
                  <div class="column has-text-centered">
                      <img width="300" src="/images/4_characters.png"/>
                      <div class="impact_item" id="impact_item_reseaux" data-aos="fade-in" style="left: 445px;  margin-top: -80px;">
                          @foreach($place->impact as $key => $impact)
                          @if(isset($impact->Reseaux) && $impact->Reseaux->show)
                          @foreach($impact->Reseaux->text as $text) @php( $impact_reseau_text = $text ) @endforeach
                          @endif
                          @endforeach
                          <div @isset($impact_reseau_text) data-tooltip="{{ $impact_reseau_text }}" @endisset class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_reseau_text) impact-disabled @endisset">
                              <svg  width="215" height="150" viewBox="20 20 75 40">
                                  <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
                                  <text x="45" y="40" font-size="8" font-weight="bold" fill="#004c44">Réseaux</text>
                              </svg>
                          </div>
                      </div>
                      <div class="impact_item" id="impact_item_appartenance" data-aos="fade-right" style="margin-top: -345px; left: 785px;">
                          @foreach($place->impact as $key => $impact)
                          @if(isset($impact->Appartenance) && $impact->Appartenance->show)
                          @foreach($impact->Appartenance->text as $text) @php( $impact_appartenance_text = $text ) @endforeach
                          @endif
                          @endforeach
                          <div @isset($impact_appartenance_text) data-tooltip="{{ $impact_appartenance_text }}" @endisset class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_appartenance_text) impact-disabled @endisset">
                              <svg  width="215" height="150" viewBox="20 20 75 40">
                                  <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
                                  <text x="35" y="38" font-size="8" font-weight="bold" fill="#004c44">Appartenance</text>
                                  <text x="40" y="46" font-size="8" font-weight="bold" fill="#004c44">ou exclusion</text>
                              </svg>
                          </div>
                      </div>
                  </div>
                  <div  class="column has-text-centered" style="position: relative;">
                      <img width="200" src="/images/3_characters.png"/>
                      <div class="impact_item" id="impact_item_sante" data-aos="fade-in" style="top: -45px; left: 85px;">
                          @foreach($place->impact as $key => $impact)
                          @if(isset($impact->Sante) && $impact->Sante->show)
                          @foreach($impact->Sante->text as $text) @php( $impact_sante_text = $text ) @endforeach
                          @endif
                          @endforeach
                          <div @isset($impact_sante_text) data-tooltip="{{ $impact_sante_text }}" @endisset class="impact_tooltip has-tooltip-bottom  has-tooltip-multiline @empty($impact_sante_text) impact-disabled @endisset">
                              <svg  width="215" height="150" viewBox="20 20 75 40">
                                  <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10" />
                                  <text x="48" y="38" font-size="7" font-weight="bold" fill="#004c44">Santé</text>
                                  <text x="44" y="45" font-size="7" font-weight="bold" fill="#004c44">Bien être</text>
                              </svg>
                          </div>
                      </div>
                      <div class="impact_item" id="impact_item_insertion" data-aos="fade-in" style="bottom: -40px; left: 50px;">
                          @foreach($place->impact as $key => $impact)
                          @if(isset($impact->Insertion) && $impact->Insertion->show)
                          @foreach($impact->Insertion->text as $text) @php($impact_insertion_text = $text ) @endforeach
                          @endif
                          @endforeach
                          <div @isset($impact_insertion_text) data-tooltip="{{ $impact_insertion_text }}" @endisset class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_insertion_text) impact-disabled @endisset">
                              <svg width="215" height="150" viewBox="20 20 75 40">
                                  <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
                                  <text x="45" y="38" font-size="8" font-weight="bold" fill="#004c44">Insertion</text>
                                  <text x="34" y="45" font-size="8" font-weight="bold" fill="#004c44">professionnelle</text>
                              </svg>
                          </div>
                      </div>
                      <div class="impact_item" id="impact_item_lien" data-aos="fade-in" style="top: -45px; right: 130px;">
                          @foreach($place->impact as $key => $impact)
                          @if(isset($impact->Lien) && $impact->Lien->show)
                          @foreach($impact->Lien->text as $text) @php($impact_lien_text = $text) @endforeach
                          @endif
                          @endforeach
                          <div @isset($impact_lien_text) data-tooltip="{{ $impact_lien_text }}" @endisset class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_lien_text) impact-disabled @endisset">
                              <svg  width="215" height="150" viewBox="20 20 75 40">
                                  <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10" />
                                  <text x="52" y="38" font-size="7" font-weight="bold" fill="#004c44">Lien</text>
                                  <text x="50" y="45" font-size="7" font-weight="bold" fill="#004c44">social</text>
                              </svg>
                          </div>
                      </div>
                      <div class="impact_item" id="impact_item_capacite" data-aos="fade-in" style="bottom: -40px;right: 80px;">
                          @foreach($place->impact as $key => $impact)
                          @if(isset($impact->Capacite) && $impact->Capacite->show)
                          @foreach($impact->Capacite->text as $text) @php( $impact_capacite_text = $text ) @endforeach
                          @endif
                          @endforeach
                          <div @isset( $impact_capacite_text ) data-tooltip="{{ $impact_capacite_text }}" @endisset class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_capacite_text) impact-disabled @endisset">
                              <svg width="215" height="150" viewBox="20 20 75 40">
                                  <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
                                  <text x="43" y="38" font-size="8" font-weight="bold" fill="#004c44">Capacité</text>
                                  <text x="50" y="45" font-size="8" font-weight="bold" fill="#004c44">à agir</text>
                              </svg>
                          </div>
                      </div>
                  </div>
              </section>
          @endif
        <section class="section anchor" id="territoire">
          <h2 class="ribbon-banner title is-5 has-text-centered">Le lieu dans son territoire</h2>
          <div class="section">
            <div class="columns">
              <div class="column">
                <label class="is-pulled-right pt-4">Choississez un découpage géographique: </label>
              </div>
              <div class="column is-pulled-left">
                <div class="mb-5 control has-icons-left">
                  <div class="select">
                    <select id="selectGeo">
                      <option value="iris" selected>Proximité immédiate</option>
                      <option value="commune">Commune</option>
                      <option value="departement">Département</option>
                      <option value="region">Région</option>
                    </select>
                  </div>
                  <span class="icon is-large is-left">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
              </div>
            </div>

            <div class="columns card is-rounded">
              <div class="column " style="width: 100%;height: 30em; z-index:1">
                <div id="map-insee"></div>
              </div>
              <div class="column is-7">
                <div class="columns">
                  <div class="column">
                      <div id="actifsChart" width="100" height="10"></div>
                      <div id="cateChart" width="100" height="10"></div>
                      <div id="immoChart" width="100" height="10"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
</div>


@endsection
