<header class="hero is-dark is-fixed-top">
        <div class="hero-head">
            <nav class="navbar" role="navigation" aria-label="main navigation">
                <div class="container">
                    <div class="navbar-brand">
                        <a class="navbar-item" href="/">
                            <img src="https://fakeimg.pl/350x200/?text={{ config('app.name') }}&font=lobster&retina=2" alt="Logo">
                        </a>
                    </div>
                    <div id="navbarMenuHeroA" class="navbar-menu">
                        <div class="navbar-end">
                            <a class="navbar-item is-active" href="/">
                                Commune mesure
                            </a>
                            <a class="navbar-item">
                                Vue globale
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="hero-body">
            <div class="container has-text-centered app-name">
                <h1 class="title">{{ config('app.name') }}</h1>

                <h2 class="subtitle">
                    Les lieux et leurs impacts
                </h2>
            </div>
            <div class="column">

                <a class="button is-primary is-inverted">
                    <span class="icon">
                      <i class="fas fa-book"></i>
                    </span>
                    <span id="guide">TÉLÉCHARGER LE GUIDE COMPLET EN PDF</span>
                </a>

            </div>

        </div>
        @includeIf("components.header-place", ["place"])
    </header>
