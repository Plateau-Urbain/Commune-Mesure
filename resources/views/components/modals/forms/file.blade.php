@php $photos = $place->getPhotos(); @endphp

@empty($photos)
  <p class="has-text-centered">Il n'y a pas encore de photo</p>
@else
  <div class="columns is-multiline">
    @foreach($photos as $photo)
      <div class="column is-one-third">
        <div class="card">
          <div class="card-image">
            <figure class="image is-4by3">
              <img src="{{ url('/images/lieux/') }}/{{ $photo }}" alt="Image du lieu">
            </figure>
          </div>
          <footer class="card-footer has-background-danger">
            <a href="{{ route('photo.delete', ['slug' => $slug, 'auth' => $auth, 'index' => $loop->index, 'id_section' => $id_section]) }}"
             class="card-footer-item has-text-white">
               <i class="fa fa-times mr-1"></i> Supprimer
          </a>
          </footer>
        </div>
      </div>
    @endforeach
  </div>
@endempty

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

@section('script_js')
@parent
<script>
  const fileInput = document.querySelector('#file-galerie-add input[type=file]');
  fileInput.onchange = () => {
    if (fileInput.files.length > 0) {
      const fileName = document.querySelector('#file-galerie-add .file-name');
      fileName.textContent = fileInput.files[0].name;
    }
  }
</script>
@endsection
