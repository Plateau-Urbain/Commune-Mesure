<h2 class="sous-banner">GALERIE
  @if(isset($edit))
    <span class="icon-edit">
      <a href="{{ route('place.editGalerie', ['slug' => $slug, 'auth' => $auth]) }}"> <i class="fa fa-pen modal-crayon" title="Éditer"></i></a>
    </span>
  @endif
</h2>
<p class='description-section has-text-centered'>Des photos du lieu !</p>
<div class="container carousel-container with-padding column is-6 has-text-centered">
    @php $array_photos = $place->getPhotos(); @endphp
    @unless(empty($array_photos))
    <div id="place-carousel" class="carousel" data-navigation=1>
      @foreach ($array_photos as $photo)
        @if($photo)
          <div class="item-{{ $loop->iteration }}" >
            <figure class="image is-covered images-lieu">
              <img src="{{ url('/images/lieux/') }}/{{$photo }}">
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
