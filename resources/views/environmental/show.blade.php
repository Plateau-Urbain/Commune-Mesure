@extends('environmental.layout')

@section('meta_share')
    @include('partials.place.meta.opengraph')
    @include('partials.place.meta.twitter')
@endsection

@section('script_js')
    @parent
    <script src="{{ url('/js/readmore.js') }}@manifest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('js.place.modals')

    <script>
        function openTab(tabId, clickedElement) {
            // Get all elements with the class "active"
            var activeElements = document.querySelectorAll('.active');

            // Remove the "active" class from each element
            activeElements.forEach(function(element) {
                element.classList.remove('active');
            });

            // Hide all tab contents
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('show');
            }

            clickedElement.classList.add('active');

            // Show the selected tab content
            document.getElementById(tabId).classList.add('show');
        }

        document.getElementById("tab1").classList.add('show');


        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'radar',
            defaults: {
                font: {
                    size: 24,
                }
            },
            data: {
                labels: [
                    ['SENSIBILISATION', 'ET ENGAGEMENT'],
                    ['CIRCULARITÉ', 'ET SOBRIÉTÉ'],
                    'BIODIVERSITÉ',
                    ['EMISSIONS', 'DE GES'],
                    ['ENVIRONNEMENT', 'PHYSIQUE'],
                ],
                datasets: [{
                    data: [{{ $axes_totals['sensibilisation_engagement'] }}, {{$axes_totals['circularite_sobriete'] }}, {{ $axes_totals['biodiversite'] }}, {{ $axes_totals['emission_gaz_effet_serre'] }},  {{ $axes_totals['environnement_physique'] }}],
                    fill: true,
                    backgroundColor: 'rgba(7, 149, 56, 0.5)',
                    pointBackgroundColor: [
                      '#F78248',
                      '#FBDA6E',
                      '#6E9E75',
                      '#457989',
                      '#4FBBD1'
                    ],
                    pointRadius: 5
                }]
            },
            options: {
                aspectRatio: 2,
                elements: {
                    line: {
                        borderWidth: 3
                    }
                },
                layout: {
                    padding: {
                        left: 50,
                        right: 50,
                        top: 0,
                        bottom: 0
                    }
                },
                scales: {

                    r: {
                        suggestedMin: 0,
                        suggestedMax: 1,
                        pointLabels: {
                            font: {
                                size: 14,
                                family: "'Renner Black'",
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                        labels: {
                            font: {
                                family: "'Renner Black'"
                            }
                        }
                    },
                    tooltip: {
                      enabled: false
                    }
                }
            }
        });
    </script>
@endsection

@section('content')
    <div class="container mx-auto mt-6">
        <div style="display: flex; gap: 25px;">
            <div style="flex:2">
                <p class="title-info">Engagement environnemental de</p>
                @section('title')
                    <h1>
                        {{ $place->get('name') }}
                    </h1>
                @show
                <p title="{{ $place->get('address->city') }}" style="white-space: nowrap; text-overflow: '... ({{ substr($place->get('address->postalcode'), 0, 2) }})'; overflow: hidden;" class="title-info">{{ str_replace('Arrondissement', '', $place->get('address->city')) }}</span> ({{ substr($place->get('address->postalcode'), 0, 2) }})</p>
                <!--<p class="link">Télécharger la fiche en format pdf</p>-->
                @if ($place->get('creator->email') !== null && $placeEnvironment->get('share_email') === 'Yes')
                  <a href="mailto:{{$place->get('creator->email')}}" class="contact mt-2">contactez-nous</a>
                @endif

                <h3 class="mt-6">raison d'être</h3>
                <p class="mt-2">{{ $placeEnvironment->get('blocs->presentation->donnees->raison_etre') }}</p>
            </div>
            <div style="flex:1; min-width:600px" class="diagram-container">
                <div style="width: 100%; position: relative;" class="mt-4">
                    <canvas id="myChart"></canvas>
                </div>
                <div style="width:400px; margin:auto; text-transform:uppercase; display: flex; flex-wrap:wrap;align-items: end; justify-content:center" class="mt-4 mb-4">
                  @foreach($selected_words as $word)
                      {!! $word !!}
                  @endforeach
                </div>
            </div>
        </div>
        <div class="tabs-container mt-6 mb-6">
            <div class="tabs">
                <div class="tab active" onclick="openTab('tab1', this)">
                    circularité et sobriété
                    <div class="progress-bar">
                        <div class="progress circularite_sobriete" style="width:{{ 103*$axes_totals['circularite_sobriete'] }}px"></div>
                    </div>
                </div>
                <div class="tab" onclick="openTab('tab2', this)">
                    emissions de ges
                    <div class="progress-bar">
                        <div class="progress emission_gaz_effet_serre" style="width:{{ 103*$axes_totals['emission_gaz_effet_serre'] }}px"></div>
                    </div>
                </div>
                <div class="tab" onclick="openTab('tab3', this)">
                    biodiversité
                    <div class="progress-bar">
                        <div class="progress biodiversite" style="width:{{ 103*$axes_totals['biodiversite'] }}px"></div>
                    </div>
                </div>
                <div class="tab" onclick="openTab('tab4', this)">
                    environnement physique
                    <div class="progress-bar">
                        <div class="progress environnement_physique" style="width:{{ 103*$axes_totals['environnement_physique'] }}px"></div>
                    </div>
                </div>
                <div class="tab" onclick="openTab('tab5', this)">
                    sensibilisation et engagement
                    <div class="progress-bar">
                        <div class="progress sensibilisation_engagement" style="width:{{ 103*$axes_totals['sensibilisation_engagement'] }}px"></div>
                    </div>
                </div>
            </div>

            <div id="tab1" class="tab-content">
                <div class="flex" style="gap:70px">
                    <div class="img-container m-6">
                        <img src="{{ url('/images/environment/circularite-sobriete.svg') }}" alt="circularité et sobriété">
                    </div>
                    <div>
                        <h2 class="mt-6">Engagement sur la circularité et la sobriété</h2>
                        <div class="bars">
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['circularite_sobriete']['moins_consommer'] }}px;background-color: #FBDA6E;"></div>
                                </div>
                                <span class="bold">Moins consommer</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['circularite_sobriete']['mieux_consommer'] }}px;background-color: #E6B206;"></div>
                                </div>
                                <span class="bold">Mieux consommer</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['circularite_sobriete']['gerer_dechet'] }}px;background-color: #AF7F00;"></div>
                                </div>
                                <span class="bold">Gérer les déchets</span>
                            </div>
                        </div>
                        <h3 class="mt-6">Action mise en avant</h3>
                        <p>
                            {{ $placeEnvironment->get('blocs->circularite_sobriete->donnees->circularite_sobriete_action') }}
                        </p>
                    </div>
                </div>
                <div class="flex ml-6 mr-6" style="gap: 50px; align-items: center;">
                    <div class="italic">
                      @if ($axes_totals['circularite_sobriete'] <= 0.25)
                          <p>La consommation n'est pas un sujet au cœur de l'engagement de notre tiers-lieu.</p>
                      @elseif ($axes_totals['circularite_sobriete'] > 0.25 && $axes_totals['circularite_sobriete'] < 0.75)
                          <p>Nous travaillons à limiter la consommation sur notre tiers-lieu. On peut toujours faire mieux, mais les premières pierres sont déjà posées !</p>
                      @elseif ($axes_totals['circularite_sobriete'] >= 0.75)
                          <p>Halte à la consommation débridée ! Sur notre tiers-lieu, vous trouverez des alternatives à l'achat neuf et une alimentation locale.</p>
                      @else
                      @endif
                    </div>
                    @php
                      list($wrappedPercentageOrNumber, $wrappedRestOfSentence) = extractPercentageAndText($placeEnvironment->get('blocs->circularite_sobriete->donnees->circularite_sobriete_chiffre'));
                    @endphp
                    {!! $wrappedPercentageOrNumber . $wrappedRestOfSentence !!}
                </div>
            </div>
            <div id="tab2" class="tab-content">
                <div class="flex" style="gap:70px">
                    <div class="img-container m-6">
                        <img src="{{ url('/images/environment/emission-ges.svg') }}" alt="emissions de ges">
                    </div>
                    <div>
                        <h2 class="mt-6">Emissions de gaz à effet de serre</h2>
                        <div class="bars">
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['emission_gaz_effet_serre']['empreinte_carbone'] }}px;background-color: #EFFBFF;"></div>
                                </div>
                                <span class="bold">Comprendre son empreinte carbone</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['emission_gaz_effet_serre']['limiter_emission'] }}px;background-color: #95B0B9;"></div>
                                </div>
                                <span class="bold">Limiter les émissions liées au transport</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['emission_gaz_effet_serre']['alimentation_faible_carbone'] }}px;background-color: #638A96;"></div>
                                </div>
                                <span class="bold">Proposer une alimentation à faible impact carbone</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['emission_gaz_effet_serre']['limiter_consommation_energie'] }}px;background-color: #457989;"></div>
                                </div>
                                <span class="bold">Limiter la consommation d'énergie du tiers-lieu</span>
                            </div>
                        </div>
                        <h3 class="mt-6">Action mise en avant</h3>
                        <p>
                          {{$placeEnvironment->get('blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_action')}}
                        </p>
                    </div>
                </div>
                <div class="flex ml-6 mr-6" style="gap: 50px; align-items: center;">
                  <div class="italic">
                    @if ($axes_totals['emission_gaz_effet_serre'] <= 0.25)
                        <p>La réduction de nos émissions de GES est encore un chantier à planifier.</p>
                    @elseif ($axes_totals['emission_gaz_effet_serre'] > 0.25 && $axes_totals['emission_gaz_effet_serre'] < 0.75)
                        <p>Nous avons entamé le chantier de la réduction de nos émissions de GES.</p>
                    @elseif ($axes_totals['emission_gaz_effet_serre'] >= 0.75)
                        <p>Nous savons d'où viennent nos principales émissions de GES, et mettons en œuvre des actions pour les réduire dans différents domaines : énergie, transport, bâtiment…</p>
                    @else
                    @endif
                  </div>
                  @php
                    list($wrappedPercentageOrNumber, $wrappedRestOfSentence) = extractPercentageAndText($placeEnvironment->get('blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_chiffre'));
                  @endphp
                  {!! $wrappedPercentageOrNumber . $wrappedRestOfSentence !!}
              </div>
            </div>
            <div id="tab3" class="tab-content">
                <div class="flex" style="gap:70px">
                    <div class="img-container m-6">
                        <img src="{{ url('/images/environment/biodiversite.svg') }}" alt="biodiversité">
                    </div>
                    <div>
                        <h2 class="mt-6">Engagement sur la biodiversité</h2>
                        <div class="bars">
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['biodiversite']['nature_tiers_lieux'] }}px;background-color: #D0EBD4;"></div>
                                </div>
                                <span class="bold">Mieux connaître la nature sur le tiers-lieu</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['biodiversite']['limitation_pression_biodiversite'] }}px;background-color: #99C7A0;"></div>
                                </div>
                                <span class="bold">Limiter mes pressions sur la biodiversité</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['biodiversite']['encourager_biodiversite'] }}px;background-color: #6E9E75;"></div>
                                </div>
                                <span class="bold">Encourager la biodiversité</span>
                            </div>
                        </div>
                        <h3 class="mt-6">Action mise en avant</h3>
                        <p>
                          {{$placeEnvironment->get('blocs->biodiversite->donnees->biodiversite_action')}}
                        </p>
                    </div>
                </div>
                <div class="flex ml-6 mr-6" style="gap: 50px; align-items: center;">
                  <div class="italic">
                    @if ($axes_totals['biodiversite'] <= 0.25)
                        <p>Nous sommes encore débutants sur le sujet de la biodiversité.</p>
                    @elseif ($axes_totals['biodiversite'] > 0.25 && $axes_totals['biodiversite'] < 0.75)
                        <p>Quelques actions sont mises en place pour accueillir et protéger la biodiversité sur le tiers-lieu.</p>
                    @elseif ($axes_totals['biodiversite'] >= 0.75)
                        <p>La biodiversité trouve refuge sur notre tiers-lieu, de nombreuses initiatives sont mises en place pour l'accueillir et la protéger.</p>
                    @else
                    @endif
                  </div>
                  @php
                    list($wrappedPercentageOrNumber, $wrappedRestOfSentence) = extractPercentageAndText($placeEnvironment->get('blocs->biodiversite->donnees->biodiversite_chiffre'));
                  @endphp
                  {!! $wrappedPercentageOrNumber . $wrappedRestOfSentence !!}
              </div>
            </div>
            <div id="tab4" class="tab-content">
                <div class="flex" style="gap:70px">
                    <div class="img-container m-6">
                        <img src="{{ url('/images/environment/environnement-physique.svg') }}" alt="environnement physique">
                    </div>
                    <div>
                        <h2 class="mt-6">Engagement sur l'environnement physique</h2>
                        <div class="bars">
                            <!--<div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 50px;background-color: #D2F6FD;"></div>
                                </div>
                                <span class="bold">Identifier les vulnérabilités du tiers-lieu</span>
                            </div>-->
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['environnement_physique']['limite_impact_sol'] }}px;background-color: #8EDCEB;"></div>
                                </div>
                                <span class="bold">Limiter l'impact du tiers-lieu sur les sols</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['environnement_physique']['qualite_quantite_eau'] }}px;background-color: #4FBBD1;"></div>
                                </div>
                                <span class="bold">Veiller à la qualité et la quantité d'eau</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['environnement_physique']['qualite_air'] }}px;background-color: #5894A0;"></div>
                                </div>
                                <span class="bold">Améliorer la qualité de l'air</span>
                            </div>
                        </div>
                        <h3 class="mt-6">Action mise en avant</h3>
                        <p>
                          {{$placeEnvironment->get('blocs->environnement_physique->donnees->environnement_physique_action')}}
                        </p>
                    </div>
                </div>
                <div class="flex ml-6 mr-6" style="gap: 50px; align-items: center;">
                  <div class="italic">
                    @if ($axes_totals['environnement_physique'] <= 0.25)
                        <p>Nos dépendances à l'environnement et nos impacts sur notre l’eau, l’air, les sols, sont encore des enjeux dont nous devons nous saisir.</p>
                    @elseif ($axes_totals['environnement_physique'] > 0.25 && $axes_totals['environnement_physique'] < 0.75)
                        <p>Nous avons conscience des dépendances et des pressions de notre tiers-lieu sur son environnement physique et essayons de limiter notre impact sur la qualité de l'eau, du sol ou de l'air.</p>
                    @elseif ($axes_totals['environnement_physique'] >= 0.75)
                        <p>Nous avons conscience des dépendances et des pressions de notre tiers-lieu sur son environnement physique et mettons en place de nombreuses actions pour limiter nos impacts sur l'eau, le sol ou l'air.</p>
                    @else
                    @endif
                  </div>
                  @php
                    list($wrappedPercentageOrNumber, $wrappedRestOfSentence) = extractPercentageAndText($placeEnvironment->get('blocs->environnement_physique->donnees->environnement_physique_chiffre'));
                  @endphp
                  {!! $wrappedPercentageOrNumber . $wrappedRestOfSentence !!}
              </div>
            </div>
            <div id="tab5" class="tab-content">
                <div class="flex" style="gap:70px">
                    <div class="img-container m-6">
                        <img src="{{ url('/images/environment/sensibilisation-engagement.svg') }}" alt="sensibilisation et engagement">
                    </div>
                    <div>
                        <h2 class="mt-6">Sensibilisation et engagement</h2>
                        <div class="bars">
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['sensibilisation_engagement']['sensibilisation_interne'] }}px;background-color: #FFAF88;"></div>
                                </div>
                                <span class="bold">Le tiers-lieu est sensibilisé</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['sensibilisation_engagement']['sensibilisation_usages'] }}px;background-color: #F78248;"></div>
                                </div>
                                <span class="bold">Le tiers-lieu sensibilise ses usagers</span>
                            </div>
                            <div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ 103*$sub_axes_totals['sensibilisation_engagement']['engagement'] }}px;background-color: #C9612D;"></div>
                                </div>
                                <span class="bold">Le tiers-lieu s'engage</span>
                            </div>
                        </div>
                        <h3 class="mt-6">Action mise en avant</h3>
                        <p>
                          {{$placeEnvironment->get('blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_action')}}
                        </p>
                    </div>
                </div>
                <div class="flex ml-6 mr-6" style="gap: 50px; align-items: center;">
                  <div class="italic">
                    @if ($axes_totals['sensibilisation_engagement'] <= 0.25)
                        <p>La sensibilisation, ce n'est pas (encore ?) au cœur de notre action.</p>
                    @elseif ($axes_totals['sensibilisation_engagement'] > 0.25 && $axes_totals['sensibilisation_engagement'] < 0.75)
                        <p>La sensibilisation ? On y travaille. Nous mettons en place des initiatives pour une partie de nos usagers.</p>
                    @elseif ($axes_totals['sensibilisation_engagement'] >= 0.75)
                        <p>La sensibilisation, c'est notre domaine ! Nous avons à cœur de toucher tous les usagers du tiers-lieu afin de les faire avancer sur leur engagement environnemental.</p>
                    @else
                    @endif
                  </div>
                  @php
                    list($wrappedPercentageOrNumber, $wrappedRestOfSentence) = extractPercentageAndText($placeEnvironment->get('blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_chiffre'));
                  @endphp
                  {!! $wrappedPercentageOrNumber . $wrappedRestOfSentence !!}
              </div>
            </div>
        </div>
    </div>
@endsection
