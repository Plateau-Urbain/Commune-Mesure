<p class='description-section has-text-centered'>
  @if(isset($edit))
    <span class="icon-edit">
      @include('components.modals.modalEdition', ['action' => 'photo.add', 'chemin' => 'galerie->donnees', 'id_section' => 'galerie', 'type' => 'file', 'titre' => "Modifier la galerie", 'description' => "Ajoutez ou supprimez des photos du lieu"])
    </span>
  @endif
</p>

<div class="container carousel-container m-0">
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
