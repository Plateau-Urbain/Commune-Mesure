@extends('layout')

@section('head_css')
    @parent

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
@endsection

@section('script_js')
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <script src="/js/map.js"></script>
    <script src="/js/animate.js"></script>

    <script>
        L.marker([{{ $place->geo->lat }}, {{ $place->geo->lon}}]).addTo(map)
        map.setView([{{ $place->geo->lat }}, {{ $place->geo->lon}}], 9)
    </script>
@endsection

@section('content')
<div class="columns is-gapless">
    <div class="column is-2">
        @include('components.place-menu')
    </div>
    <div class="column">
        <div id="presentation" class="hero is-large is-light anchor">
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

        <div id="localisation" class="anchor">
            <section class="has-background-warning section">
                <h3 class="title is-3">Localisation</h3>
            </section>
            <div id="mapid" style="height:500px; height:500px; z-index:0;"></div>
        </div>

        <div id="indicateurs" class="anchor">
            <section class="has-background-primary section">
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
                            <p class="title is-1 animate-value" data-total="12000" >12000</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section">
                <div class="columns">
                    <div class="column is-one-third has-text-centered">
                        <img src="/images/visualization.svg" alt="graphique"/>
                    </div>
                    <div class="column">
                        <p>Lorem Salu bissame ! Wie geht's les samis ? Hans apporte moi une Wurschtsalad avec un picon bitte, s'il te plaît.
                          Voss ? Une Carola et du Melfor ? Yo dû, espèce de Knäckes, ch'ai dit un picon !</p>
                        <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au Christkindelsmärik en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                        <p>Yoo ch'ai lu dans les DNA que le Racing a encore perdu contre Oberschaeffolsheim. Verdammi et moi ch'avais donc parié deux knacks et une flammekueche. Ah so ? T'inquiète, ch'ai ramené du schpeck, du chambon, un kuglopf et du schnaps dans mon rucksack. Allez, s'guelt ! Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p>
                        <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="columns">
                    <div class="column">
                        <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                        <blockquote><p>Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p></blockquote>
                        <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                    </div>
                    <div class="column is-half has-text-centered">
                        <img src="/images/visualization2.svg" alt="graphique">
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
