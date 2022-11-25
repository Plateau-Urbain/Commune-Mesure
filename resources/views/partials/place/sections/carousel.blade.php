@if(isset($edit))
<p class='description-section has-text-centered'>
    <span class="icon-edit">
      @include('components.modals.modalEdition', ['action' => 'photo.add', 'chemin' => 'galerie->donnees', 'id_section' => 'galerie', 'type' => 'file', 'titre' => "Modifier la galerie", 'description' => "Ajoutez ou supprimez des photos du lieu. (Taille minimale recommandée de 1000x500)"])
    </span>
</p>
@endif

<div class="container carousel-container">
    @php $array_photos = $place->getPhotos(); @endphp
    @unless(empty($array_photos))
    <div id="place-carousel" class="carousel" data-navigation=1>
      @foreach ($array_photos as $photo)
        @if($photo)
          <div class="item-{{ $loop->iteration }}" >
            <figure class="image is-contained images-lieu">
              <img src="{{ url('/images/lieux/') }}/{{$photo }}">
            </figure>
          </div>
        @endif
      @endforeach
    </div>
    @else
      <div class="has-text-centered">
        <p>Il n'y a pas encore de photo.</p>
      </div>
    @endunless
</div>
