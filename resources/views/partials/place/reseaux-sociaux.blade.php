<ul class="list-dotted is-hidden-print">
  @foreach ($place->get('reseaux_sociaux->donnees') as $name => $link)
    @if ($link || isset($edit))
      <li>
        <i class="fab fa-{{ $name }} has-text-primary mr-1"></i> <span class="has-text-weight-bold"{!! (! $link) ? ' style="opacity: 0.5"' : '' !!}><a href="{{ ($link) ?: '#' }}" class="social-link" target='_blank'>{{ ucwords($name) }}</a></span>
        @if(isset($edit))
          @include('components.modals.modalEdition', ['chemin' => 'reseaux_sociaux->donnees->'.$name, 'id_section' => 'presentation', 'type' => 'text', 'titre' => "Modifier l'adresse du réseau", "description" => "Modifier le réseau ".$name])
        @endif
      </li>
    @endif
  @endforeach
</ul>

{{-- https://github.com/bradvin/social-share-urls --}}
<div class="dropdown is-hoverable is-hidden-print">
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
