@extends('layout')

@section('head_css')
    @parent

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css" type="text/css">
@endsection

@section('script_js')
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-gesture-handling"></script>
    <script src="/js/map.js"></script>
    <script src="/js/animate.js"></script>
    <script>
        var largemap = mapjs.create('mapid', {gestureHandling: true})
        var smallmap = mapjs.create('info-box-map')
        L.marker([{{ $place->geo->lat }}, {{ $place->geo->lon}}]).addTo(largemap)
        L.marker([{{ $place->geo->lat }}, {{ $place->geo->lon}}]).addTo(smallmap)
        largemap.setView([{{ $place->geo->lat }}, {{ $place->geo->lon}}], 9)
        smallmap.setView([{{ $place->geo->lat }}, {{ $place->geo->lon}}], 9)
    </script>
@endsection

@section('content')
<div class="columns is-gapless">
    <div class="column is-2">
        {{-- @include('components.place-menu') --}}
        @include('components.place.info-box')
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

        <div id="localisation" class="anchor">
            <section class="section">
                <h3 class="title is-3">Localisation</h3>
            </section>
            <div id="mapid" style="height:500px; height:500px; z-index:0;"></div>
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
                    <div class="column is-one-third has-text-centered">
                        <img src="/images/visualization.svg" alt="graphique"/>
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
                        <img src="/images/visualization2.svg" alt="graphique">
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
