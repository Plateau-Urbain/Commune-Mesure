<script>
  var geoDataPlace = JSON.parse("{{ json_encode($coordinates) }}".replace(/&quot;/g,'"'));
  document.querySelectorAll("div.map-place").forEach(nodeMap => {
    var id = nodeMap.getAttribute("id");
    var mapnode = document.getElementById(id);
    var namePlace = id.replace("map_", '');
    if (!geoDataPlace[namePlace]) {
        console.log(namePlace+" not found ("+id+")");
        return;
    }
    var latLon = [geoDataPlace[namePlace].geo.lat, geoDataPlace[namePlace].geo.lon];
    var mapPlace = mapjs.create(id, {gestureHandling: true})
    L.marker(latLon).addTo(mapPlace)
    mapPlace.setView(latLon, 9)

  })

</script>
