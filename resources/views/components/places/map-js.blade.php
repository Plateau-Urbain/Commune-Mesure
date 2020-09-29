<script>
  var geoDataPlace = JSON.parse("{{ json_encode($coordinates) }}".replace(/&quot;/g,'"'));
  document.querySelectorAll("div.map-place").forEach(nodeMap => {
    var id = nodeMap.getAttribute("id");
    var mapnode = document.getElementById(id);
    mapnode.style.height = "22em";
    var namePlace = id.split("_")[1];
    var latLon = [geoDataPlace[namePlace].geo.lat, geoDataPlace[namePlace].geo.lon];
    var mapPlace = mapjs.create(id, {gestureHandling: true})
    L.marker(latLon).addTo(mapPlace)
    mapPlace.setView(latLon, 9)

  })

</script>
