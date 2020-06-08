<aside id="info-box" class="scrolling-menu">
    <h3 class="info-box-header">Localisation</h3>
    <div class="info-box-content">
        <div id="info-box-map" class="info-box-map"></div>
        <dl>
            <dt><a href="geo:{{ $place->geo->lat }},{{ $place->geo->lon }}">Adresse</a></dt>
            <dd>{{ $place->address->address }}, {{ $place->address->postalcode }} {{ $place->address->city }}</dd>
        </dl>
    </div>
    <h3 class="info-box-header">Informations</h3>
    <div class="info-box-content">
        <div class="columns is-multiline is-gapless">
            <div class="column is-half">
                <span class="info-box-entry">Création</span>
            </div>
            <div class="column is-half">
                <date datetime="{{ $place->creation }}">{{
                    date_create_from_format('Y-m-d', $place->creation)->format('d/m/Y') }}
                </date>
            </div>

            <div class="column is-half">
                <span class="info-box-entry">Création</span>
            </div>
            <div class="column is-half">
                <date datetime="{{ $place->ouverture }}">{{
                    date_create_from_format('Y-m-d', $place->ouverture)->format('d/m/Y') }}
                </date>
            </div>

            <div class="column is-half">
                <span class="info-box-entry">Gestionnaires</span>
            </div>
            <div class="column is-half">
                <ul>
                @foreach ($place->manager as $manager)
                    <li>{{ $manager }}</li>
                @endforeach
                </ul>
            </div>

            <div class="column is-half">
                <span class="info-box-entry">Status</span>
            </div>
            <div class="column is-half">
                {{ $place->status }}
            </div>
        </div>
    </div>
    <h3 class="info-box-header">Réseaux sociaux</h3>
    <div class="info-box-content columns is-multiline has-text-centered is-gapless">
        @foreach ($place->social as $social)
            <span class="column is-half">
                <a href="{{ $social->link }}">{{ $social->name }}&nbsp;↗</a>
            </span>
        @endforeach
    </div>
</aside>
