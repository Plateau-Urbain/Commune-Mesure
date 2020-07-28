<script>
  var geoDataPlace = JSON.parse("{{ json_encode($place->geo) }}".replace(/&quot;/g,'"'));
  var geoJsonIris = geoDataPlace.geo_json.iris;
  var geoJsonDepartement = geoDataPlace.geo_json.departement;
  var geoJsonRegion = geoDataPlace.geo_json.region;
  var markerPoint = [geoDataPlace.lat, geoDataPlace.lon];
  var mapnode = document.getElementById('map-insee');
  var zoomDefault = 12;
  var zoomDepartement = 10;
  var mygeojson;
  /**
  * Css style departement
  **/
  function styleDepartement(){
      return {
          fillColor: '#d0f3fb',
          weight: 0,
          opacity: 2,
          color: 'white',
          fillOpacity: 0.7
      }
  }

  /**
  * Css style region
  * //TODO opacity light
  **/
  function styleRegion(){
      return {
          fillColor: '#3d1e6d',
          weight: 0,
          opacity: 2,
          color: 'white',
          fillOpacity: 0.7
      }
  }

  /**
  * Css style default
  **/
  function style(){
      return {
          fillColor: '#f37736',
          weight: 0,
          opacity: 2,
          color: 'white',
          fillOpacity: 0.7
      }
  }
  /**
  * Load data geoJson in function of zoom level
  */

  function loadGeoJson(){
    //TODO clean map before add new layer
    if(mapInsee.getZoom() > zoomDefault){
      mygeojson = L.geoJSON(
        geoJsonIris,
        {style: style}).addTo(mapInsee);
    }
    if(mapInsee.getZoom() <= zoomDefault && mapInsee.getZoom() > zoomDepartement){
      mygeojson = L.geoJSON(
        geoJsonDepartement,
        {style: styleDepartement}).addTo(mapInsee);
    }
    if(mapInsee.getZoom() <= zoomDepartement){
      mygeojson = L.geoJSON(
        geoJsonRegion,
        {style: styleRegion}).addTo(mapInsee);
    }
    mapInsee.fitBounds(mygeojson.getBounds());

  }

  mapnode.style.width = "auto";
  mapnode.style.height = "100%";

  var mapInsee = mapjs.create('map-insee', {gestureHandling: true})
  mapInsee.setView(markerPoint, 13);

  loadGeoJson();
  mapInsee.on("zoom", loadGeoJson);

  L.marker(markerPoint).addTo(mapInsee)
      .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
      .openPopup();
</script>
