@extends('layout')

@section('title')
  {{-- vide --}}
@endsection

@section('content')
    <div id="page-listing-lieux" class="container">
        <div class="hero is-large mt-4">
            <section class="section pb-0">
                <h1 style="color: #413f4b;" class="title is-3 has-text-centered is-uppercase">L’ensemble des lieux recensés</h1>
            </section>
        </div>
        <div class="mt-5 mx-6 p-2" style="background-color: #e1ebf2">
          <!-- Filtre des Régions et Départements -->
          <form method="GET" action="{{ route('places') }}" style="display: flex; flex-direction: row; gap: 50px; align-items: center; justify-content: center;">
            <div class="form-group">
                <select name="location" id="location" class="select is-rounded">
                    <option value="">-- Toutes les Régions et Départements --</option>
                    @foreach($regions as $region)
                        <optgroup label="{{ $region->name }}">
                            <option value="region_{{ $region->id }}" {{ request('location') == 'region_'.$region->id ? 'selected' : '' }}>
                                Toute la région {{ $region->name }}
                            </option>
                            @foreach($region->departements as $departement)
                                <option value="departement_{{ $departement->id }}" {{ request('location') == 'departement_'.$departement->id ? 'selected' : '' }}>
                                    - {{ $departement->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div>
              <input type="checkbox" id="social_effect" name="social_effect"  {{ request('social_effect') ? 'checked' : '' }} />
              <label for="social_effect">Effets sociaux</label>
            </div>

            <div>
              <input type="checkbox" id="environmental" name="environmental"  {{ request('environmental') ? 'checked' : '' }} />
              <label for="environmental">Effets environnementaux</label>
            </div>

            <button type="submit" class="button is-transparent is-primary">Filtrer</button>
          </form>
        </div>
        <div class="section">
          <p class="block has-text-grey mb-3">Trié par : les plus récents</p>
          <div class="columns is-multiline">
            @foreach ($places as $place)
              <div class="column is-3">
                <div class="card" style="height: 100%;">
                  <div class="card-image">
                    <div id="carousel-{{ $place->getSlug() }}" class="carousel-listing carousel-container" style="height: 250px;">
                      @if (count($place->getPhotos()) > 0)
                        @foreach ($place->getPhotos() as $photo)
                          <figure class="image contained">
                            <img src="{{ url('/') }}/images/lieux/thumbnail/{{ $photo }}">
                          </figure>
                        @endforeach
                      @endif

                      <div style="z-index: -1;" class="map-place" id="map_{{ $place->getSlug() }}"></div>
                    </div>
                  </div>

                  <div class="card-content p-4" style="display: flex; justify-content: space-between; flex-direction: column; height: 330px;">
                    <div style="justify-content: normal;">
                      <p title="{{ $place->get('address->city') }}" style="white-space: nowrap; text-overflow: '... ({{ substr($place->get('address->postalcode'), 0, 2) }})'; overflow: hidden;" class="is-size-5 has-text-weight-normal">{{ str_replace('Arrondissement', '', $place->get('address->city')) }}</span> ({{ substr($place->get('address->postalcode'), 0, 2) }})</p>
                      <a title="{{ $place->get('name') }}" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-size: 1.4rem !important;" class="title has-text-primary is-uppercase is-size-5 mb-0"
                        @if ($place->isPublish()) href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" @else style="cursor: not-allowed" @endif
                      >{{ $place->get('name') }}</a>

                      <div class="content mt-1">
                        @if ($place->isPublish())
                          <p style="text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3;-webkit-box-orient: vertical;">{!! str_replace( "\\n", '<br />', $place->get('blocs->presentation->donnees->idee_fondatrice')) !!}</p>
                        @else
                          <p class="has-text-grey-light">Plus d'infos à venir&hellip; Dès la publication du datapanorama par les responsables du tiers lieux.</p>
                        @endif
                      </div>
                    </div>
                    <div style="justify-content: flex-end">
                    @if ($place->isPublish())
                      @if (!empty($place->get('blocs->impact_social')))
                        <a href="{{ route('impacts.show',['slug' => $place->getSlug() ]) }}" class="button is-fullwidth">Voir ses effets sociaux</a>
                      @else
                        <button type="button" disabled href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2 is-transparent">Voir ses effets sociaux</button>
                      @endif
                      <a href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2">Voir son datapanorama</a>
                      @if (true === $place['hasEnvironmentalPart'])
                        <a href="{{ route('environment.show',['slug' => $place->getSlug() ]) }}" class="button is-fullwidth mt-2">Voir ses effets environnementaux</a>
                      @else
                        <button type="button" disabled href="{{ route('environment.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2 is-transparent">Voir ses effets environnementaux</button>
                      @endif
                    @else
                      <button type="button" disabled href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2 is-transparent">Voir ses effets sociaux</button>
                      <button type="button" disabled href="{{ route('place.show', ['slug' => $place->getSlug()]) }}" class="button is-fullwidth mt-2 is-transparent">Voir son datapanorama</button>
                    @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          {!! $paginatedPlaces->links() !!}
        </div>
    </div>

@endsection
@section('script_js')
  @parent
  @include('partials.places.map-js')
@endsection
