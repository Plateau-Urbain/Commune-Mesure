<div class="container carousel-container with-padding column is-6 has-text-centered">
  <h2 class="ribbon-banner is-5">Gallerie</h2>
  @unless(empty($place->photos))
  <div id="place-carousel" class="carousel" data-navigation=1>
    @foreach ($place->photos as $photo)
    <div class="item-{{ $loop->iteration }}">
      <figure class="image is-covered">
        <img src="/images/lieux/{{ $photo }}">
      </figure>
    </div>
    @endforeach
  </div>
  @else
    <div>
      <p>Il n'y a pas encore de photo.</p>
      @isset($edit)
        @include('components.modals.modalEdition', ['chemin' => 'photos'])
      @endisset
    </div>
  @endunless
</div>
