@inject('str', Illuminate\Support\Str::class)

<h4 class="subtitle is-5">
  Accès
  @include('components.modals.modalEdition', ['chemin'=>'blocs->accessibilite->donnees->transports', 'id_section'=>'accessibilite','type' => 'checkbox','titre' => 'Modifier les moyens de transports accessibles',"description"=>"L'accessibilité du lieu en transports en commun"])
</h4>

@if($place->getTransports() !== null)
  <div class="columns is-multiline">
    @foreach($place->getTransports() as $transport => $check)
      @if ($check)
        <span class="ml-3 cm-icons-container">
          <i class="cm-icons {{ $str->slug($transport) }} mr-1"></i>
          <br/>{{ $transport }}
        </span>
      @endif
    @endforeach
  </div>
@endif
