@extends('layout')

@section('content')
<style media="screen">
  .banner{
    display: none;
  }
</style>
    <div class="container">
        <div class="hero is-large is-light">
            <section class="section">
                <h1 class="title is-1 has-text-centered">Les lieux</h1>
                <div class="column">
                    <p>Lorem Salu bissame ! Wie geht's les samis ? Hans apporte moi une Wurschtsalad avec un
                      picon bitte, s'il te plaît.
                        Voss ? Une Carola et du Melfor ? Yo dû, espèce de Knäckes, ch'ai dit un picon !</p>
                    <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de
                       Bischheim était au Christkindelsmärik en compagnie de Richard Schirmeck (celui qui
                       a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck
                       ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                    <p>Yoo ch'ai lu dans les DNA que le Racing a encore perdu contre Oberschaeffolsheim.
                      Verdammi et moi ch'avais donc parié deux knacks et une flammekueche. Ah so ? T'inquiète,
                      ch'ai ramené du schpeck, du chambon, un kuglopf et du schnaps dans mon rucksack. Allez, s'guelt ! Wotch
                      a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange
                      plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p>
                    <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais
                      che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour
                      les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                </div>
            </section>
        </div>
        <div class="section">
            @foreach ($cities as $city => $places)
                <div class="box content">
                    <div class="columns is-bordered places-block">
                        <div class="column">
                            <p class="title">{{ $city  }}</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                              Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas
                               non massa sem. Etiam finibus odio quis feugiat facilisis.</p>
                            <div>
                                <ul>
                                    @foreach($places as $place)
                                        <li><a href="{{ route('place.show',['slug' => $place['name']])  }}">{{ $place['title']  }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="column has-text-centered">
                            <img src="https://fakeimg.pl/350x200/?text={{  $city }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
