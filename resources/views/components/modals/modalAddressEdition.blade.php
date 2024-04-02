@if(!isset($edit))
  @php return @endphp
@endif
<span class="icon-edit">
    <a class='crayons' href="#{{$id_section}}"><i class="fa fa-pen modal-crayon" data-modal="modal_address" title="Éditer"></i></a>
</span>

@push('modals')
<div class="modal" id="modal_address" style="z-index: 1000000000">
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
    <form method="POST" action="{{ route($action ?? 'place.address.update', ['slug' => $slug, 'auth' => $auth, 'id_section' => $id_section]) }}">
      <section>
        @isset($description)
          <small>{{ $description }}</small>
          <hr class="is-primary-light"/>
        @endisset

        @php  $address = $place->get("address->address") @endphp
        Adresse
        <input class="input" type="text" name="address" value="{{ $address }}">

        @php  $city = $place->get("address->city") @endphp
        Ville
        <input class="input" type="text" name="city" value="{{ $city }}">

        @php  $postalcode = $place->get("address->postalcode") @endphp
        Code postal
        <input class="input" type="text" name="postalcode" value="{{ $postalcode }}">

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
