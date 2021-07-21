<script>
  var placeName = "{{ $place->get('name') }}"
  var geoDataPlace = JSON.parse("{{ json_encode($place->get('blocs->data_territoire->donnees->geo')) }}".replace(/&quot;/g,'"'));
  var placeData = JSON.parse("{{ json_encode($place->get('blocs->data_territoire->donnees')) }}".replace(/&quot;/g,'"'));
  var address = @json($place->get('address'));
  var geoJsonFeatures = geoDataPlace.geo_json;

  //Set style map div
  var mapnode = document.getElementById('map-insee');
  mapnode.style.width = "auto";
  mapnode.style.height = "100%";

  var zoomDefault = 20;
  var zoomIris = 14;
  var zoomCommune = 12;
  var zoomDepartement = 10;
  var mygeojson;
  var marker;
  var starting_zone = "iris";
  var styleObjet = {
    fillColor: '#f37736',
    weight: 0,
    opacity: 2,
    color: 'white',
    fillOpacity: 0.3
  };
</script>
