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
        function openTab(tabId) {
            // Hide all tab contents
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('show');
            }

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
                    data: [65, 59, 90, 81, 56],
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
                <p class="link">Télécharger la fiche en format pdf</p>
                <p class="contact mt-2">contactez-nous</p>

                <h3 class="mt-6">raison d'être</h3>
                <p class="mt-2">{{ $placeEnvironment->get('blocs->presentation->donnees->raison_etre') }}</p>
            </div>
            <div style="flex:1; min-width:600px" class="diagram-container">
                <div style="width: 100%; position: relative;" class="mt-4">
                    <canvas id="myChart"></canvas>
                </div>
                <div style="width:300px; margin:auto; text-transform:uppercase; display: flex; flex-wrap:wrap;" class="mt-4">
                    @php
                        function generateRandomSpans($inputString, $className = '') {
                            $randomSizes = array_map(fn() => rand(15, 50), explode(' ', $inputString));

                            return array_map(
                                fn($word, $size) => "<span class=\"$className\" style=\"font-size: {$size}px; margin:0px 5px;\">{$word}</span>",
                                explode(' ', $inputString),
                                $randomSizes
                            );
                        }
                        $circularite_sobriete = generateRandomSpans($placeEnvironment->get('blocs->circularite_sobriete->donnees->circularite_sobriete_action'), 'circularite-sobriete');
                        $emission_gaz_effet_serre = generateRandomSpans($placeEnvironment->get('blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_action'), 'emission-gaz-effet-serre');
                        $biodiversite = generateRandomSpans($placeEnvironment->get('blocs->biodiversite->donnees->biodiversite_action'), 'biodiversite');
                        $environnement_physique = generateRandomSpans($placeEnvironment->get('blocs->environnement_physique->donnees->environnement_physique_action'), 'environnement-physique');
                        $sensibilisation_engagement = generateRandomSpans($placeEnvironment->get('blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_action'), 'sensibilisation-engagement');

                        $combinedArray = array_merge($circularite_sobriete, $emission_gaz_effet_serre, $biodiversite, $environnement_physique, $sensibilisation_engagement);

                        //shuffle($combinedArray);

                        $verbatim = implode($combinedArray)
                    @endphp
                    {!! $verbatim !!}
                </div>
            </div>
        </div>
        <div class="tabs-container mt-6">
            <div class="tabs">
                <div class="tab" onclick="openTab('tab1')">circularité et sobriété</div>
                <div class="tab" onclick="openTab('tab2')">emissions de ges</div>
                <div class="tab" onclick="openTab('tab3')">biodiversité</div>
                <div class="tab" onclick="openTab('tab4')">environnement physique</div>
                <div class="tab" onclick="openTab('tab5')">sensibilisation et engagement</div>
            </div>

            <div id="tab1" class="tab-content">
                <div class="flex" style="gap:70px">
                    <div class="img-container m-4">
                        <img src="{{ url('/images/environment/circularite-sobriete.svg') }}" alt="circularité et sobriété">
                    </div>
                    <div>
                        <h2 class="mt-2">Engagement sur la circularité et la sobriété</h2>
                        <div>
                            <div>Moins consommer</div>
                            <div>Mieux consommer</div>
                            <div>Gérer les déchets</div>
                        </div>
                        <h3 class="mt-2">Action mise en avant</h3>
                        <p>
                            Tout comme les projets Nursery de plants maraîchers bio et Maraîchage solidaire, pour permettre à tous de trouver une alimentation durable et plus indirectement de favoriser l’accompagnement de personnes éloignées de l’emploi et préserver la biodiversité.
                        </p>
                    </div>
                </div>
                <div class="flex" style="gap: 50px">
                    <div class="italic">Nous travaillons à limiter la consommation sur notre tiers-lieu. On peut toujours faire mieux, mais les premières pierres sont déjà posées !</div>
                    <div class="number">85%</div>
                    <div class="bold">des produits alimentaires que nous achetons sont bio et produit à mois de 15 km du lieu.</div>
                </div>
            </div>
            <div id="tab2" class="tab-content">
                <div class="img-container">
                    <img src="{{ url('/images/environment/emission-ges.svg') }}" alt="emissions de ges">
                </div>
            </div>
            <div id="tab3" class="tab-content">
                <div class="img-container">
                    <img src="{{ url('/images/environment/biodiversite.svg') }}" alt="biodiversité">
                </div>
            </div>
            <div id="tab4" class="tab-content">
                <div class="img-container">
                    <img src="{{ url('/images/environment/environnement-physique.svg') }}" alt="environnement physique">
                </div>
            </div>
            <div id="tab5" class="tab-content">
                <div class="img-container">
                    <img src="{{ url('/images/environment/sensibilisation-engagement.svg') }}" alt="sensibilisation et engagement">
                </div>
            </div>
        </div>
    </div>
@endsection
