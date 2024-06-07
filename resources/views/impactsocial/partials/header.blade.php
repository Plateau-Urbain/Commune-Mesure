@include("partials/header-mobile")
@include("generate/header")
<div class="impact-title">
    @section('title')
    <h1>
        <span style="color:#262631">effets sociaux et urbains</span><br>de {{ $place->get('name') }}
    </h1>
    <div>
        <a href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button mt-6 is-hidden-print">Voir son datapanorama</a>
    </div>
    <p class="link is-hidden-print"><a href="{{ route('impacts.export', ['slug' => $place->getSlug()]) }}">Télécharger la fiche en format pdf</a></p>
    @show

    @section('header.submenu')
    @show
</div>
