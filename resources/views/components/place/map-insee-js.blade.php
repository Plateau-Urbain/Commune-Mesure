<script>
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

  L.geoJSON({"type": "Polygon", "coordinates": [[[2.229103483277047, 48.90603335333204], [2.220399433954488, 48.920617920983446], [2.231143021098716, 48.927737920336384], [2.247595355674966, 48.93673642401929], [2.27303937214216, 48.93383585141546], [2.273314401521025, 48.92684997013363], [2.257413276511337, 48.91355962855995], [2.229103483277047, 48.90603335333204]]]}).addTo(mapInsee);
  L.marker([48.9225179147,2.24675160629]).addTo(mapInsee)
      .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
      .openPopup();
</script>
