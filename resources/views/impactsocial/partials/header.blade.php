@include("partials/header-mobile")
@include("generate/header")
<div class="impact-title">
    @section('title')
    <h1>
        La mesure des impacts<br> sociaux et urbains de {{ $place->get('name') }}
    </h1>
    <a href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button mt-6">Voir son datapanorama</a>
    @show

    @section('header.submenu')
    @show
</div>
