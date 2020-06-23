@extends('layout')
@section('head_css')
    @parent
@endsection
@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
@endsection
@section('content')
  <div class="container">
      <div class="hero is-large is-light">
          <div class="section">
              <div class="columns">
                  <div class="column content">
                    <h1 class="title is-1 has-text-centered">Les données et statistiques des lieux</h1>
                  </div>
                  <div class="column is-half has-text-centered">
                    <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias</p>
                    <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci</p>
                  </div>
              </div>
          </div>
        </div>
        <div class="section">
          <div class="columns">
            <div class="column has-text-centered">
              <div class="box content">
                <p class="title"><a href="{{ route('impacts.datas')  }}">Ces données précieuses</a></p>
                <p>Lorem Salu bissame ! Wie geht's les sa dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                <p>Yoo ch'ai lu dans les DNA que le Racing a encore perdu contre</p>
                <p>Oberschaeffolsheim. Verdammi et moi ch'avais donc parié deux </p>
              </div>
            </div>
            <div class="column has-text-centered">
              <div class="box content">
                <p class="title"><a href="{{ route('impacts.statistics')  }}">Des statistiques pour comprendre les lieux</a>
                </p>
                  <p>knacks et une flammekueche. Ah so ? T'inquiète, ch'ai ramené du schpeck, du chambon, un kuglopf et du schnaps dans mon rucksack.</p>
                  <p> Allez, s'guelt ! Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection
