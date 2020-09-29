@extends('layout')

@section('content')
    <div class="container">
        <div class="hero is-large is-light">
            <section class="section">
                <h1 class="title is-1 has-text-centered">Les lieux</h1>
                <!-- <div class="column">
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
                </div> -->
            </section>
        </div>
        <div class="section">

            @foreach ($cities as $city => $places)
            @foreach($places as $place)
                <div class="box content">
                    <div class="columns is-bordered places-block">
                        <div class="column">
                            <p class="title"><a href="{{ route('place.show',['slug' => $place['name']])  }}">{{ $place['title']  }}</a></p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                              Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas
                               non massa sem. Etiam finibus odio quis feugiat facilisis.</p>
                            <div>
                                <ul class="">

                                        <p><strong>{{ $city  }}</strong></p>

                                </ul>
                            </div>
                        </div>
                        <div class="column is-one-third has-text-centered" style="overflow-x: hidden">
                            <div id="carousel-{{ $place['name'] }}" class="carousel">
                                <div class="item-1">
                                    <img src="https://fakeimg.pl/350x200/?text={{ $city }}">
                                </div>
                                <div class="item-2">
                                    <img src="https://fakeimg.pl/350x200/?text={{ $city }}-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  @endforeach
              @endforeach
        </div>
    </div>

@endsection
