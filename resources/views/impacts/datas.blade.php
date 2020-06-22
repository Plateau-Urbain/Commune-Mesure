@extends('layout')
@section('head_css')
    @parent
    <style>
      #myProgress {
        width: 100%;
        background-color: #ddd;
        border-radius: 1em;
      }

      .myBar {
        width: 10%;
        height: 1.5em;
        background-color: #4CAF50;
        text-align: center;
        line-height: 30px;
        color: white;
        border-radius: 1em;
      }
    </style>
@endsection
@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    @include('components.impacts.chart-datas')
@endsection
@section('content')
  <div class="">
      <div class="hero is-large is-light">
          <div class="section">
              <div class="columns">
                  <div class="column content">
                    <h1 class="title is-1 has-text-centered">Les données</h1>
                  </div>
                  <div class="column is-half has-text-centered">
                    <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                    <blockquote><p>Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p></blockquote>
                    <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                    <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias</p>
                    <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci</p>
                  </div>
              </div>
              @foreach($places as $place)
                <div class="columns">
                  <div class="column is-3">
                    <p class="is-3"><a href="{{ route('place.show',['slug' => $place->title])  }}">{{ $place->name }}</a></p>
                  </div>
                <div class="column">
                  @foreach($place->data->resilience as $resilience)
                    <p class="is-1">{{ $resilience->title }}</p>
                    <div id="myProgress">
                      <div class="myBar" data-fill="{{ $resilience->city }}" data-full="{{ $resilience->total }}">10%</div>
                    </div>
                  @endforeach
                </div>
                <div class="column">
                  Chart
                </div>
                </div>
                @endforeach
                </div>
              </div>
          </div>
        </div>
      </div>
  </div>
@endsection
