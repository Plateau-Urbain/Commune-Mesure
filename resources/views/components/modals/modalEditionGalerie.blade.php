@if(!isset($edit))
  @php return @endphp
@endif
<div class="modal is-active" id="{{$chemin}}" style="z-index: 100000;">
  <div class="modal-background" ></div>
  <div class="modal-card">

    <header class="modal-card-head">
      <div class="modal-card-title">
        <h2>
          Modifier la galerie
         </h2>
      </div>
       <a href="{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $auths[$place->getSlug()]])}}#section07"><button class="delete modal-croix" aria-label="close"></button></a>
       <br>

    </header>

    <form method="POST" action="{{route('place.updateGalerie',['slug' => $slug, 'auth' => $auth , 'chemin'=>$chemin])}}" enctype="multipart/form-data">
        <section class="modal-card-body">
          @php $array_photos = $place->getPhotos();@endphp
            @unless(empty($array_photos))
            <div class="carousel" data-navigation=1>
              @foreach($array_photos as $photo)
              @if($photo)
                <div>
                  <button name="supprimer" style="z-index:1000;position:absolute;" class="button pull-right is-danger" type="submit" value="{{ array_search($photo,$array_photos) }}"><i class="fas fa-times"></i></button>
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
          <br>
        <footer class="modal-card-foot" style="border-bottom: 1px solid #dbdbdb" >
          <span class="container">
            <label>Ajouter une image : </label><input id='image' type='file' accept="image/jpeg" name='image'/>
            <button name="ajouter" class="button is-success" type="submit" value='ajouter'>Ajouter</button>
          </span>
        </footer>
        <br>
        <span class="container">
          <span class="field is-grouped is-grouped-left">
            <a href="{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $auths[$place->getSlug()]]) }}#section07"><input class="button" type='button' value="Fermer"/></button></a>
          </span>
        </span>

    </form>
</div>
</div>
@include('place.show')
