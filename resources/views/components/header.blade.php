<header>
<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item" href="/"><img src="{{ url('/images/logos/commune-mesure.png') }}" alt='logo'></a>
        </div>

        <div id="navbarMenuHeroA" class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item" href="/">Accueil</a>
                <a class="navbar-item" href="/les-lieux">Les lieux</a>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link" href="/les-donnees">Les données</a>
                    <div class="navbar-dropdown is-boxed">
                        <a class="navbar-item">Nos précieuses données</a>
                        <a class="navbar-item">Les statistiques</a>
                    </div>
                </div>
                <a class="navbar-item" href="/documentation">Documentation</a>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link" href="les-institutions">Les institutions</a>
                    <div class="navbar-dropdown is-boxed">
                        <a class="navbar-item">SNCF</a>
                        <a class="navbar-item">Plateau Urbain</a>
                    </div>
                </div>
                <a class="navbar-item" href="/contact-us">Nous contacter</a>
            </div>
        </div>
    </div>
</nav>
<div class="hero">
    <div class="hero-body">
        <div class="container has-text-centered app-name">
            <h1 class="title">{{ config('app.name') }}</h1>

            <h2 class="subtitle">
                Les lieux et leurs impacts
            </h2>
        </div>
    </div>

    @section('header.submenu')
    @show
</div>
</header>
