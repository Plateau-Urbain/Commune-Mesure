<div class="hero is-primary-light">
    <div class="section">
        <h1 class="title has-text-centered">Les lieux hybrides en chiffres</h1>
        <div class="level block-data-stat">
            <div class="level-item level-item-home has-text-centered">
                <div>
                    <p class="title animate-value is-1" id="animate-place" data-total={{ count($coordinates) }}>{{ str_replace(","," ",number_format(count($coordinates))) }}</p>
                    <p class="heading title is-4">Lieux</p>
                </div>
            </div>
            <div class="level-item level-item-home has-text-centered">
                <div>
                    <p class="title animate-value is-1" id="animate-city" data-total={{ $stats['cities'] }}>{{ str_replace(","," ",number_format($stats['cities'])) }}</p>
                    <p class="heading title is-4">Communes</p>
                </div>
            </div>
            <div class="level-item level-item-home has-text-centered">
                <div>
                    <p class="title animate-value is-1" id="animate-meters" data-total={{ $stats['surface'] }}>{{ str_replace(","," ",number_format($stats['surface'])) }}</p>
                    <p class="heading title is-4">m<sup>2</sup></p>
                </div>
            </div>
            <div class="level-item level-item-home has-text-centered">
                <div>
                    <p class="title animate-value is-1" id="animate-emplois directs" data-total={{ $stats['emplois directs'] }}>{{ str_replace(","," ",number_format($stats['emplois directs'])) }}</p>
                    <p class="heading title is-4">Emplois</p>
                    <p class="heading title is-4">directs</p>
                </div>
            </div>
            <div class="level-item level-item-home has-text-centered">
                <div>
                    <p class="title animate-value is-1" id="animate-events" data-total={{ $stats['evenements'] }}>{{ str_replace(","," ",number_format($stats['evenements'])) }}</p>
                    <p class="heading title is-4">Événements</p>
                    <p class="heading title is-4">organisés</p>
                </div>
            </div>
            <div class="level-item level-item-home has-text-centered">
                <div>
                    <p class="title animate-value is-1" id="animate-personnes accueillies" data-total={{ $stats['personnes accueillies'] }}>{{ str_replace(","," ",number_format($stats['personnes accueillies'])) }}</p>
                    <p class="heading title is-4">Personnes</p>
                    <p class="heading title is-4">accueillies</p>
                </div>
            </div>
        </div>
    </div>
</div>
