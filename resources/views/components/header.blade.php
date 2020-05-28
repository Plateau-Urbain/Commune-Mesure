<header class="hero is-dark is-fixed-top">
    <div class="hero-head">
        <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item" href="/">{{ config('app.name') }}</a>
                </div>

                <div id="navbarMenuHeroA" class="navbar-menu">
                    <div class="navbar-end">
                        <a class="navbar-item" href="/">Accueil</a>
                        <a class="navbar-item">Les lieux</a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">Les données</a>
                            <div class="navbar-dropdown is-boxed">
                                <a class="navbar-item">Mes précieuses données</a>
                                <a class="navbar-item">Statistiques</a>
                            </div>
                        </div>
                        <a class="navbar-item">Documentation</a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">Les institutions</a>
                            <div class="navbar-dropdown is-boxed">
                                <a class="navbar-item">SNCF</a>
                                <a class="navbar-item">Plateau Urbain</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="hero-body less">
        <div class="container has-text-centered app-name">
            <h1 class="title">{{ config('app.name') }}</h1>

            <h2 class="subtitle">
                Les lieux et leurs impacts
            </h2>
        </div>
    </div>

    @section('header.submenu')
    @endsection
</header>
