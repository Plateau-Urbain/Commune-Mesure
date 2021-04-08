<h2 class="sous-banner">GALERIE</h2>
<div class="container carousel-container with-padding column is-6 has-text-centered">
    @php $array_photos = $place->getPhotos(); @endphp
    @unless(empty($array_photos))
    <div id="place-carousel" class="carousel" data-navigation=1>
      @foreach ($array_photos as $photo)
        @if($photo)
          <div class="item-{{ $loop->iteration }}">
            <figure class="image is-covered">
              <img src="/images/lieux/{{ $photo }}">
            </figure>
          </div>
        @endif
      @endforeach
    </div>
    @else
      <div>
        <p>Il n'y a pas encore de photo.</p>
      </div>
    @endunless
</div>
