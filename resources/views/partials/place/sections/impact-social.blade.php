<h2 class="ribbon-banner title is-5 has-text-centered">L'impact social</h2>
<div class="columns" style="margin-top: 100px;">
  {{-- Gauche --}}
  <div class="column has-text-centered is-relative">

    <img width="300" src="/images/4_characters.png"/>

    <div class="impact_item bottom left" id="impact_item_reseaux" data-aos="fade-in">
      <x-edit-section :edit="isset($edit)" section="reseau" :sections="$sections">
        @isset($edit)
        <x-slot name="url">
          <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'reseau']) }}">
        </x-slot>
        @endisset

        @foreach($place->impact as $key => $impact)
          @if(isset($impact->Reseaux) && $impact->Reseaux->show)
            @foreach($impact->Reseaux->text as $text) @php( $impact_reseau_text = $text ) @endforeach
          @endif
        @endforeach
        <div @isset($impact_reseau_text) data-tooltip="{{ $impact_reseau_text }}" @endisset class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_reseau_text) impact_disabled @endisset">
          <svg  width="215" height="150" viewBox="20 20 75 40">
            <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
            <text x="45" y="40" font-size="8" font-weight="bold" fill="#004c44">Réseaux</text>
          </svg>
        </div>
      </x-edit-section>
    </div>

    <div class="impact_item top right" id="impact_item_appartenance" data-aos="fade-right">
      <x-edit-section :edit="isset($edit)" section="appartenance" :sections="$sections" id="appartenance">
        @isset($edit)
        <x-slot name="url">
          <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'appartenance']) }}">
        </x-slot>
        @endisset

        @foreach($place->impact as $key => $impact)
          @if(isset($impact->Appartenance) && $impact->Appartenance->show)
            @foreach($impact->Appartenance->text as $text) @php( $impact_appartenance_text = $text ) @endforeach
          @endif
        @endforeach
        <div @isset($impact_appartenance_text) data-tooltip="{{ $impact_appartenance_text }}" @endisset class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_appartenance_text) impact_disabled @endisset">
          <svg  width="215" height="150" viewBox="20 20 75 40">
            <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
            <text x="35" y="38" font-size="8" font-weight="bold" fill="#004c44">Appartenance</text>
            <text x="40" y="46" font-size="8" font-weight="bold" fill="#004c44">ou exclusion</text>
          </svg>
        </div>
      </x-edit-section>
    </div>
  </div>

  {{-- Droite --}}
  <div  class="column has-text-centered" style="position: relative;">

    <img width="200" src="/images/3_characters.png"/>

    <div class="impact_item top left" id="impact_item_sante" data-aos="fade-in">
      <x-edit-section :edit="isset($edit)" section="sante" :sections="$sections" id="sante">
        @isset($edit)
        <x-slot name="url">
          <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'sante']) }}">
        </x-slot>
        @endisset

        @foreach($place->impact as $key => $impact)
          @if(isset($impact->Sante) && $impact->Sante->show)
            @foreach($impact->Sante->text as $text) @php( $impact_sante_text = $text ) @endforeach
          @endif
        @endforeach
        <div @isset($impact_sante_text) data-tooltip="{{ $impact_sante_text }}" @endisset class="impact_tooltip has-tooltip-bottom  has-tooltip-multiline @empty($impact_sante_text) impact_disabled @endisset">
          <svg  width="215" height="150" viewBox="20 20 75 40">
            <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10" />
            <text x="48" y="38" font-size="7" font-weight="bold" fill="#004c44">Santé</text>
            <text x="44" y="45" font-size="7" font-weight="bold" fill="#004c44">Bien être</text>
          </svg>
        </div>
      </x-edit-section>
    </div>

    <div class="impact_item bottom left" id="impact_item_insertion" data-aos="fade-in">
      <x-edit-section :edit="isset($edit)" section="insertion" :sections="$sections" id="insertion">
        @isset($edit)
        <x-slot name="url">
          <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'insertion']) }}">
        </x-slot>
        @endisset

        @foreach($place->impact as $key => $impact)
          @if(isset($impact->Insertion) && $impact->Insertion->show)
            @foreach($impact->Insertion->text as $text) @php($impact_insertion_text = $text ) @endforeach
          @endif
        @endforeach
        <div @isset($impact_insertion_text) data-tooltip="{{ $impact_insertion_text }}" @endisset class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_insertion_text) impact_disabled @endisset">
          <svg width="215" height="150" viewBox="20 20 75 40">
            <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
            <text x="45" y="38" font-size="8" font-weight="bold" fill="#004c44">Insertion</text>
            <text x="34" y="45" font-size="8" font-weight="bold" fill="#004c44">professionnelle</text>
          </svg>
        </div>
      </x-edit-section>
    </div>

    <div class="impact_item top right" id="impact_item_lien" data-aos="fade-in">
      <x-edit-section :edit="isset($edit)" section="lien_sociaux" :sections="$sections" id="lien_sociaux">
        @isset($edit)
        <x-slot name="url">
          <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'lien_sociaux']) }}">
        </x-slot>
        @endisset

        @foreach($place->impact as $key => $impact)
          @if(isset($impact->Lien) && $impact->Lien->show)
            @foreach($impact->Lien->text as $text) @php($impact_lien_text = $text) @endforeach
          @endif
        @endforeach
        <div @isset($impact_lien_text) data-tooltip="{{ $impact_lien_text }}" @endisset class="impact_tooltip has-tooltip-bottom has-tooltip-multiline @empty($impact_lien_text) impact_disabled @endisset">
          <svg  width="215" height="150" viewBox="20 20 75 40">
            <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10" />
            <text x="52" y="38" font-size="7" font-weight="bold" fill="#004c44">Lien</text>
            <text x="50" y="45" font-size="7" font-weight="bold" fill="#004c44">social</text>
          </svg>
        </div>
      </x-edit-section>
    </div>

    <div class="impact_item bottom right" id="impact_item_capacite" data-aos="fade-in">
      <x-edit-section :edit="isset($edit)" section="capacite" :sections="$sections" id="capacite">
        @isset($edit)
        <x-slot name="url">
          <a href="{{ route('place.toggle', ['slug' => $slug, 'auth' => $auth, 'section' => 'capacite']) }}">
        </x-slot>
        @endisset

        @foreach($place->impact as $key => $impact)
          @if(isset($impact->Capacite) && $impact->Capacite->show)
            @foreach($impact->Capacite->text as $text) @php( $impact_capacite_text = $text ) @endforeach
          @endif
        @endforeach
        <div @isset( $impact_capacite_text ) data-tooltip="{{ $impact_capacite_text }}" @endisset class="impact_tooltip has-tooltip-top has-tooltip-multiline @empty($impact_capacite_text) impact_disabled @endisset">
          <svg width="215" height="150" viewBox="20 20 75 40">
            <path class="path-2s" stroke-dasharray="414" fill="none" stroke="black" stroke-width="1.2" d="M 30 30 a 3 1 0 0 1 50 20 a -3 -1 1 0 1 -40 -20 m 0 -10"/>
            <text x="43" y="38" font-size="8" font-weight="bold" fill="#004c44">Capacité</text>
            <text x="50" y="45" font-size="8" font-weight="bold" fill="#004c44">à agir</text>
          </svg>
        </div>
      </x-edit-section>
    </div>

  </div>
</div>
