@if(!isset($edit))
  @php return @endphp
@endif
<span class="icon-edit">
    <a class='crayons' href="#{{$id_section}}"><i class="fa fa-pen modal-crayon" data-modal="{{$chemin}}" title="Éditer"></i></a>
</span>
<div class="modal" id="{{$chemin}}" style="z-index: 100000;">
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

    <form method="POST" action="{{ route('place.update', ['slug' => $slug, 'auth' => $auth, 'hash' => $chemin, 'id_section' => $id_section])}}">
      <section class="modal-card-body">
        @isset($description)
          <small>{{ $description }}</small>
          <hr class="is-primary-light"/>
        @endisset

        @php $valueChemin = $place->get($chemin) @endphp
        @include('components.modals.forms.'.$type ?? 'text', [
          'value' => $place->get($chemin),
          'path' => $chemin,
          'name' => str_replace('->', '__', $chemin)
        ])

        <br>
        <span style="opacity: 0.2;">$place->{{ $chemin }}</span>
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
