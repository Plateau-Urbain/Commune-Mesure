<header>
<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="/"><img src="{{ url('/images/logos/commune-mesure.png') }}" alt='logo'></a>
        </div>

        <div id="navbarMenuHeroA" class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item" href="/">Accueil</a>
                <a class="navbar-item" href="{{ route("places") }}">Les lieux</a>
                <a class="navbar-item" href="{{ route('impacts.show') }}">Les données</a>
                <a class="navbar-item" href="{{ route('partners') }}">Les partenaires</a>
            </div>
        </div>
    </div>
</nav>
<div class="banner hero">
    <div class="hero-body">
        <div class="container has-text-centered app-name">
            @section('title')
            <h1 class="title header-title">
            Commune Mesure
            </h1>
            <h2 class="subtitle">
                Les lieux et leurs impacts
            </h2>
            @show
        </div>
    </div>

    @section('header.submenu')
    @show
</div>
</header>
