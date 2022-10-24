<script>
  @if($place->getVisibilitybySection('accessibilite') && !isset($edit) || isset($edit))
    var placeLatLon = {
        'lat': {{ $place->get('blocs->data_territoire->donnees->geo->lat') }},
        'lon': {{ $place->get('blocs->data_territoire->donnees->geo->lon') }}
    }
  @endif
</script>
