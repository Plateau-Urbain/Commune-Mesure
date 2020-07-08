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
  <div class="content">
    <div class="hero is-large is-light">
      <div class="section container is-fullhd">
        <div class="columns">
          <div class="column">
            <div class="columns">
              <figure class="image is-128x128">
                <img src="{{ url('/images/statistics.svg') }}" >
              </figure>

                <h1 class="title is-1 has-text-centered">Les données</h1>
            </div>

          </div>
          <div class="column  is-three-fifths ">
            <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
            <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
            <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias</p>
            <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci</p>
          </div>
        </div>
      </div>
      <div class="hero is-large is-light">
        <div class="section">
          <h1 class="title is-2 has-text-centered">Occupation des lieux</h1>
          <div class="columns">
            <div class="column">
              <div class="field">
                <div class="control">
                  <label for="first-city-select" class="title is-4">Choisissez un lieu:</label>
                  <div class="select is-small is-success" style="margin-top:1em;">
                    <select name="1" id="first-city-select" class="is-focused" onchange="comparePopulationPlaces(this)">
                      @foreach($places as $place)
                        <option value="{{ $place->title }}">{{ $place->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="box content">
                <p class="title" id="title-left"><a href="">
                </a></p>
                <p>Lorem Salu bissame ! Wie geht's les sa dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                <p>Yoo ch'ai lu dans les DNA que le Racing a encore perdu contre</p>
                <p>Oberschaeffolsheim. Verdammi et moi ch'avais donc parié deux </p>
              </div>
            </div>
            <div class="column has-text-centered">
              <canvas id="chart-overlay-compare"></canvas>
            </div>
            <div class="column">
              <div class="field">
                <div class="control">
                  <label for="second-city-select" class="title is-4">Choisissez un lieu:</label>
                  <div class="select is-small is-success" style="margin-top:1em;">
                    <select name="2" id="second-city-select" class="is-focused" onchange="comparePopulationPlaces(this)">
                      @foreach($places as $place)
                        <option value="{{ $place->title }}">{{ $place->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="box content">
                <p class="title" id="title-right"><a href="">
                </a>
                </p>
                <p>knacks et une flammekueche. Ah so ? T'inquiète, ch'ai ramené du schpeck, du chambon, un kuglopf et du schnaps dans mon rucksack.</p>
                <p> Allez, s'guelt ! Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p>
              </div>
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
          <div class="column is-10">
            <canvas id="chart-bubble-pop" ></canvas>
          </div>
          <div class="column mt-3">
            <div class="box content is-bordered">
              <div class="field is-horizontal">
                <div class="field-label">
                  <label for="abscisse" class="label">Abscisse</label>
                </div>
                <div class="field-body">
                  <div class="field is-narrow">
                    <div class="control">
                      <div class="select">
                        <select id="abscisse" name="xAxe" onchange="populationAxesChart()">
                          @foreach ($places[0]->data->population as $key => $value)
                            <option value="{{ $value }}">{{ $key }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="field is-horizontal">
                <div class="field-label">
                  <label for="ordonnee" class="label">Ordonnée</label>
                </div>
                <div class="field-body">
                  <div class="field is-narrow">
                    <div class="control">
                      <div class="select">
                        <select id="ordonnee" name="yAxe" onchange="populationAxesChart()">
                          @foreach ($places[0]->data->population as $key => $value)
                            <option value="{{ $value }}">{{ $key }}</option>
                          @endforeach
                        </select>
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
