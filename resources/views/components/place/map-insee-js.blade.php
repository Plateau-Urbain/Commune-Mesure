<script>
  var geoJsonIris = JSON.parse("{{ json_encode($place->geo->geo_json->iris) }}".replace(/&quot;/g,'"'));;
  var mapnode = document.getElementById('map-insee');
  mapnode.style.width = "auto";
  mapnode.style.height = "100%";

  var mapInsee = mapjs.create('map-insee', {gestureHandling: true})
  mapInsee.setView([48.9225179147,2.24675160629], 13);
  var markersCluster = L.markerClusterGroup();
  var groupMarker = [];
  var markerIcon = L.divIcon({
      className: 'leaflet-marker-icon leaflet-zoom-animated leaflet-interactive marker-icon-custom',
      html: "<div><span>1</span></div>",
      iconSize: [40, 40],
  });

  L.geoJSON(geoJsonIris).addTo(mapInsee);
  L.marker([48.9225179147,2.24675160629]).addTo(mapInsee)
      .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
      .openPopup();
</script>
