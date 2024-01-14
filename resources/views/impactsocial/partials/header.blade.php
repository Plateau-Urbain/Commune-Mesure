@include("partials/header-mobile")
@include("generate/header")
<div class="impact-title">
    @section('title')
    <h1>
        <span style="color:#262631">effets sociaux et urbains</span><br>de {{ $place->get('name') }}
    </h1>
    <div>
        <a href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button mt-6">Voir son datapanorama</a>
    </div>
    @show

    @section('header.submenu')
    @show
</div>
