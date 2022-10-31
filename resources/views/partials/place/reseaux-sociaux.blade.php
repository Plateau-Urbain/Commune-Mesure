@isset ($place->get('reseaux_sociaux->donnees')->web)
  <a href="{{ $place->get('reseaux_sociaux->donnees')->web }}" target="_blank" class="social-link is-size-5">Site web</a>
@endif

<ul class="list-undotted is-hidden-print is-size-5">
  <li>|</li>
  @foreach ($place->get('reseaux_sociaux->donnees') as $name => $link)
    @if ($name === 'web') @continue @endif
    @if ($link || isset($edit))
      <li>
        <a href="{{ ($link) ?: '#' }}" class="" target='_blank'>
          <i class="fab fa-{{ $name }} has-text-primary mr-1"></i>
        </a>
        @if(isset($edit))
          @include('components.modals.modalEdition', ['chemin' => 'reseaux_sociaux->donnees->'.$name, 'id_section' => 'presentation', 'type' => 'text', 'titre' => "Modifier l'adresse du réseau", "description" => "Modifier le réseau ".$name])
        @endif
      </li>
    @endif
  @endforeach
</ul>

{{-- https://github.com/bradvin/social-share-urls --}}
<div class="dropdown is-hoverable is-hidden-print social-share">
  <div class="dropdown-trigger">
    <button class="button is-small has-background-primary has-text-white" aria-haspopup="true" aria-controls="dropdown-menu">
      <i class="fa fa-share-alt mr-1" aria-hidden="true"></i> Partagez-moi
    </button>
  </div>
  <div class="dropdown-menu" role="menu">
    <div class="dropdown-content has-text-left">
      <a class="dropdown-item" href="https://www.linkedin.com/sharing/share-offsite/?url={{
        route('place.show', ['slug' => $place->getSlug()])
      }}">
        <i class="fab fa-linkedin mr-1"></i> sur LinkedIn
      </a>
      <a class="dropdown-item" href="https://facebook.com/sharer/sharer.php?u={{
        route('place.show', ['slug' => $place->getSlug()])
      }}">
        <i class="fab fa-facebook mr-1"></i> sur Facebook
      </a>
      <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{
        route('place.show', ['slug' => $place->getSlug()])
      }}">
        <i class="fab fa-twitter mr-1"></i> sur Twitter
      </a>
      <a class="dropdown-item" href="{{ route('place.export', ['slug' => $place->getSlug()]) }}">
        <i class="fa fa-image mr-1" aria-hidden="true"></i> Image
      </a>
      <a class="dropdown-item" href="{{ route('place.export', ['slug' => $place->getSlug(), 'to' => 'pdf']) }}">
        <i class="fa fa-download mr-1" aria-hidden="true"></i> Télécharger
      </a>
    </div>
  </div>
</div>
