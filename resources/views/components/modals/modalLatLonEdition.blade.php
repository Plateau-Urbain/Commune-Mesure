@if(!isset($edit))
  @php return @endphp
@endif
<span class="icon-edit">
    <a class='crayons' href="#{{$id_section}}"><i class="fa fa-pen modal-crayon" data-modal="modal_latlon" title="Éditer"> <span style="font-family:sans-serif; font-size:12px; font-style:italic; font-weight: 400">Le point affiché sur la carte n'est pas le bon ?</i> </a>
</span>

@push('modals')
<div class="modal" id="modal_latlon" style="z-index: 1000000000">
  <div class="modal-background" ></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <div class="modal-card-title">
        <h2 >
           @if(isset($titre))
              {{$titre}}
           @endif
         </h2>
      </div>
       <button class="delete modal-croix" aria-label="close"></button>
       <br>

    </header>

    <div class="modal-card-body">
    <form method="POST" action="{{ route($action ?? 'place.latlon.update', ['slug' => $slug, 'auth' => $auth, 'id_section' => $id_section]) }}">
      <section>
        @isset($description)
          <small>{{ $description }}</small>
          <hr class="is-primary-light"/>
        @endisset

        @php  $lat = $place->get("blocs->data_territoire->donnees->geo->lat") @endphp
        Latitude
        <input class="input" type="text" name="lat" value="{{ $lat }}">


        @php  $lon = $place->get("blocs->data_territoire->donnees->geo->lon") @endphp
        Longitude
        <input class="input" type="text" name="lon" value="{{ $lon }}">

        <br>
      </section>
      <footer class="modal-card-foot">
        <input type="button" class="button modal-croix" value="Annuler"/>
        <span class="container">
          <span class="field is-grouped is-grouped-right">
            <button class="button is-success" type="submit">Enregistrer</button>
          </span>
        </span>
      </footer>
    </form>
    </div>
  </div>
</div>
@endpush
