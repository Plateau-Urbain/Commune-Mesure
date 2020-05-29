@extends('layout')

@section('content')
<div class="columns is-gapless">
    <div class="column is-2">
        @include('components.place-menu')
    </div>
    <div class="column">
        <div id="presentation" class="hero is-large is-light anchor">
            <section class="section">
                <h1 class="title is-1 has-text-centered">{{ $place->name }}</h1>
                <h3 class="subtitle has-text-grey-light is-italic">Tags:
                    @foreach ($place->tags as $tag)
                        <a class="tag" href="/tag/{{ $tag }}" title="{{ $tag }}">{{ $tag }}</a>
                    @endforeach
                </h3>

                <div class="columns">
                    <div class="column is-one-third has-text-centered">
                        <img src="https://picsum.photos/500" alt="Photo" width=500 height=500/>
                    </div>
                    <div class="column content">{!! $place->description !!}</div>
                </div>
            </section>
        </div>

        <div id="federation" class="hero is-medium is-dark anchor">
            <section class="section">
                <div class="columns is-multiline">
                @foreach ($place->photos as $photo)
                    <div class="column is-one-quarter has-text-centered">
                        <img src="/images/{{ $photo }}" {{ getimagesize("images/$photo")[3] }}/>
                    </div>
                @endforeach
                </div>
            </section>
        </div>

        <div id="analyse" class="hero is-medium anchor">
            <section class="section">
                <div class="level">
                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Entreprises</p>
                            <p class="title">53</p>
                        </div>
                    </div>

                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Années d'existence</p>
                            <p class="title">3</p>
                        </div>
                    </div>

                    <div class="level-item has-text-centered">
                        <div>
                            <p class="heading">Followers</p>
                            <p class="title">12K</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div id="bilan" class="hero is-light anchor">
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
