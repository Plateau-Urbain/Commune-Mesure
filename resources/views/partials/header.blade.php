@include("partials/header-mobile")
@include("generate/header")
<div class="banner hero">
    <div class="hero-body">
        <div class="container has-text-centered app-name">
            @section('title')
            <h1 class="title header-title">
            Commune Mesure
            </h1>
            <h2 class="subtitle">
                La plateforme ressource des tiers-lieux et lieux hybrides
            </h2>
            @show
        </div>
    </div>

    @section('header.submenu')
    @show
</div>
