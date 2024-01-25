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
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'radar',
            defaults: {
                font: {
                    size: 24
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
                                size: 14
                            }
                        },
                        ticks: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
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
        <div style="display: flex">
            <div style="flex:2">
                <p>Engagement environnemental de</p>
                @section('title')
                    <h1>
                        {{ $place->get('name') }}
                    </h1>
                @show

                {{ $placeEnvironment->get('blocs->presentation->donnees->raison_etre') }}
            </div>
            <div style="flex:1; min-width:600px">
                <div style="width: 100%; position: relative;">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
