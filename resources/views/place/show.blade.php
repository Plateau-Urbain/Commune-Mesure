@extends('layout')

@section('head_css')
    @parent
@endsection
@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    <script>
      var dataIris = {x : [5,9,2,6,4,3.5,4.5,3.2,4.8],
      y : [3.5,3.2,0.3,3.6,3.9,3.4,2.9,4.9,9.6],
      "petal_length" : [1.2,1.3,1.5,1.5,0.3,0.5,1.9,1.4,1.1],
      "petal_width" : [0.2,0.2,0.2,0.2,0.2,0.2,0.2,0.2,0.2,0.4,0.3,0.1],
      "species" : ["setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa","setosa"]};

      var colors = ["#ee4035", "#f37736", "#fdf498", "#7bc043", "#0392cf",
      "#d11141", "#f37735", "#7e8d98", "#29a8ab", "#3d1e6d", "#c68642", "#d2e7ff"];
        var smallmap = mapjs.create('info-box-map')
        L.marker([{{ $place->geo->lat }}, {{ $place->geo->lon}}]).addTo(smallmap)
        smallmap.setView([{{ $place->geo->lat }}, {{ $place->geo->lon}}], 9)

        @foreach($plots as $plot)
          var chartPop = new charts.create(
              '{{ $plot->getId() }}',
              '{{ $plot->getType() }}',
              @json($plot->getLabels()),
              @json($plot->getDatasets())
          );
        @endforeach
        var dataLogement = [];
        var labelsLogement = [];
        @foreach($place->data->logement as $label => $data)
                dataLogement.push({{ $data }});
                labelsLogement.push('{{ $label }}');
        @endforeach

        var dataPopulation = [];
        var labelsPopulation = [];
        @foreach($place->data->population as $label => $data)
                dataPopulation.push({{ $data }});
                labelsPopulation.push('{{ $label }}');
        @endforeach
      // create Donut chart using defined data & customize plot options
      new roughViz.Donut(
      {
      element: '#chart-rough-logement-barh',
      data: {
       labels: labelsLogement,
       values: dataLogement
      },
      title: "Logements",
      roughness: 3,
      colors: colors,
      stroke: 'black',
      strokeWidth: 3,
      fillStyle: 'cross-hatch',
      fillWeight: 3.5,
      }
      );

      new roughViz.BarH(
      {
      element: '#chart-rough-logement-doughnut',
      data: {
       labels: labelsLogement,
       values: dataLogement
      },
      title: "Logements",
      roughness: 3,
      colors: colors,
      stroke: 'black',
      strokeWidth: 1,
      fillStyle: 'zigzag-line',
      fillWeight: 3.5,
      }
      );
      new roughViz.Scatter(
      {
        element: '#chart-rough-logement-scatter',
        data: dataIris,
        title: 'Les logements',
        colorVar: 'species',
        highlightLabel: 'species',
        fillWeight: 4,
        radius: 12,
        colors: colors,
        stroke: 'black',
        strokeWidth: 0.4,
        roughness: 0.6,
        width: window.innerWidth*0.7,
        font: 0,
        xLabel: 'sepal width',
        yLabel: 'petal length',
        curbZero: false,
      });
    </script>
@endsection

@section('content')
<div class="columns is-gapless">
    <div class="column is-2">
        {{-- @include('components.place-menu') --}}
        @include('components.place.info-box')
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

        <div id="indicateurs" class="anchor">
            <section class="section">
                <h3 class="title is-3">Indicateurs</h3>
            </section>
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

            <section class="section">
                <div class="columns">
                    <div class="column is-half has-text-centered">
                        <canvas id="chart-pop"></canvas>
                    </div>
                    <div class="column">
                        <table class="table is-fullwidth is-hoverable">
                            <tr>
                                <th>Entry Header 1</th>
                                <th>Entry Header 2</th>
                                <th>Entry Header 3</th>
                                <th>Entry Header 4</th>
                            </tr>
                            <tr>
                                <td>Entry First Line 1</td>
                                <td>Entry First Line 2</td>
                                <td>Entry First Line 3</td>
                                <td>Entry First Line 4</td>
                            </tr>
                            <tr>
                                <td>Entry Line 1</td>
                                <td>Entry Line 2</td>
                                <td>Entry Line 3</td>
                                <td>Entry Line 4</td>
                            </tr>
                            <tr>
                                <td>Entry Last Line 1</td>
                                <td>Entry Last Line 2</td>
                                <td>Entry Last Line 3</td>
                                <td>Entry Last Line 4</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="columns">
                    <div class="column content">
                        <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                        <blockquote><p>Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p></blockquote>
                        <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                    </div>
                    <div class="column is-half has-text-centered">
                        <canvas id="chart-activities"></canvas>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="columns">
                  <div class="column is-half has-text-centered">
                      <canvas id="chart-activities2"></canvas>
                  </div>
                  <div class="column content">
                      <blockquote><p>Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p></blockquote>
                  </div>
                </div>
            </section>
            <section class="section">
                <div class="columns">
                    <div class="column content">
                        <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                        <blockquote><p>Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p></blockquote>
                        <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                    </div>
                    <div class="column is-half has-text-centered">
                        <canvas id="chart-logement-radar"></canvas>
                    </div>
                    <div class="column content">
                        <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                        <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                    </div>
                </div>
            </section>
            <section class="section">
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
            <section class="section">
                <div class="columns">
                  <div class="column has-text-centered">
                    <canvas id="chart-overlay"></canvas>
                  </div>
                  <div class="column has-text-centered">
                    <canvas id="chart-pop-bar"></canvas>
                  </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
