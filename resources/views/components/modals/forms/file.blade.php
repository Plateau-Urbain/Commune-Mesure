@php $photos = $place->getPhotos(); @endphp

@empty($photos)
  <p class="has-text-centered">Il n'y a pas encore de photo</p>
@else
  <div class="container carousel-container">
    <div class="carousel" data-navigation="1">
      @foreach($photos as $photo)
        <div class="item-{{ $loop->iteration }}">
          <figure class="image is-covered images-lieu">
            <img src="{{ url('/images/lieux/') }}/{{ $photo }}">
          </figure>
        </div>
      @endforeach
    </div>
  </div>
@endempty
      @foreach($photos as $photo)
        <div class="file-galerie-delete">
          <a href="{{ route('photo.delete', ['slug' => $slug, 'auth' => $auth, 'index' => $loop->index, 'id_section' => 'galerie']) }}"
             class="button is-danger">
             <i class="fa fa-times"></i>
          </a>
      @endforeach

<hr class="is-primary-light">

<div id="file-galerie-add" class="file has-name">
  <label class="file-label">
    <input id="input-add-photo" class="file-input" type="file" accept=".jpeg,.jpg,.png,.webp" name="photo"/>
    <span class="file-cta">
      <span class="file-icon">
        <i class="fas fa-upload"></i>
      </span>
      <span class="file-label">
        Choose a file…
      </span>
    </span>
    <span class="file-name">
      No file uploaded
    </span>
  </label>
</div>

<script>
  const fileInput = document.querySelector('#file-galerie-add input[type=file]');
  fileInput.onchange = () => {
    if (fileInput.files.length > 0) {
      const fileName = document.querySelector('#file-galerie-add .file-name');
      fileName.textContent = fileInput.files[0].name;
    }
  }
</script>
