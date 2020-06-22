@extends('layout')
@section('head_css')
    @parent
@endsection
@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    @include('components.impacts.chart-statistics')
@endsection
@section('content')
  <div class="">
      <div class="hero is-large is-light">
          <div class="section">
              <div class="columns">
                  <div class="column content">
                    <h1 class="title is-1 has-text-centered">Statistiques</h1>
                  </div>
                  <div class="column is-half has-text-centered">
                    <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                    <blockquote><p>Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p></blockquote>
                    <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                    <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias</p>
                    <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci</p>
                  </div>
              </div>
          </div>
        </div>
        <div class="hero is-large is-light">
          <div class="section">

          </div>
          <div class="section">
              <h1 class="title is-2 has-text-centered">Population</h1>
              <div class="columns">

                <div class="column has-text-centered">
                  <div class="box content">
                    <p class="title"><a href="{{ route('place.show',['slug' => $cities['Paris'][1]['name']])  }}">
                      {{ $cities['Paris'][1]['title'] }}</a></p>
                    <p>Lorem Salu bissame ! Wie geht's les sa dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                    <p>Yoo ch'ai lu dans les DNA que le Racing a encore perdu contre</p>
                    <p>Oberschaeffolsheim. Verdammi et moi ch'avais donc parié deux </p>
                  </div>
                </div>
                <div class="column has-text-centered">
                  <canvas id="chart-overlay"></canvas>
                </div>
                <div class="column has-text-centered">
                  <div class="box content">
                    <p class="title"><a href="{{ route('place.show',['slug' => $cities['Paris'][0]['name']])  }}">
                      {{ $cities['Paris'][0]['title'] }}</a>
                    </p>
                      <p>knacks et une flammekueche. Ah so ? T'inquiète, ch'ai ramené du schpeck, du chambon, un kuglopf et du schnaps dans mon rucksack.</p>
                      <p> Allez, s'guelt ! Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <div class="hero is-large is-light">
          <div class="section">
              <div class="box content">
                  <div class="columns is-bordered places-block">
                      <div class="column">
                          <p class="title">Population des lieux</p>
                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas
                             non massa sem. Etiam finibus odio quis feugiat facilisis.</p>
                      </div>
                  </div>
              </div>
              <div class="columns">
                <div class="column">
                  <canvas id="chart-bubble-pop" ></canvas>
                </div>
                  <div class="column " style="margin-top:5em">
                    <div class="box content">
                      <div class="is-bordered">
                        <div class=" columns">
                          <div class="control">

                            <div class="column">
                              <p class="is-1">Abscisse</p>
                              @foreach ($places[0]->data->population as $key => $value)
                              <label class="radio">
                                <input type="radio" name="xAxe" onchange="populationAxesChart('{{ $key }}', this)">
                                {{ $key }}
                              </label>
                              @endforeach
                            </div>

                            <div class="column">
                              <p class="is-1">Ordonnée</p>
                              @foreach ($places[0]->data->population as $key => $value)
                              <label class="radio">
                                <input type="radio" name="yAxe" onchange="populationAxesChart('{{ $key }}', this)">
                                {{ $key }}
                              </label>
                              @endforeach
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
  </div>
@endsection
