<script>
  var geoDataPlace = JSON.parse("{{ json_encode($place->geo) }}".replace(/&quot;/g,'"'));
  var geoJsonFeatures = geoDataPlace.geo_json;
  var markerPoint = [geoDataPlace.lat, geoDataPlace.lon];

  //Set style map div
  var mapnode = document.getElementById('map-insee');
  mapnode.style.width = "auto";
  mapnode.style.height = "100%";

  var zoomDefault = 12;
  var zoomDepartement = 10;
  var mygeojson;

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
  *
  **/
  function onEachFeature(feature, layer) {
    if(mapInsee.getZoom() > zoomDefault && layer.feature.properties.zone !== "iris"){
      layer.setStyle({
        fillColor: 'transparent'
      })
    }
  }

  function displayFeature(zoom) {

    var color = '#3d1e6d';
    var bounds;
    mygeojson.getLayers().forEach(function (layer) {
      if(mapInsee.getZoom() > zoomDefault){
        if(layer.feature.properties.zone !== "iris"){
          layer.setStyle({
            fillColor: 'transparent'
          })
        }else{
          layer.setStyle(style());
        }
      }
      if(mapInsee.getZoom() <= zoomDefault && mapInsee.getZoom() >= zoomDepartement){
        if(layer.feature.properties.zone !== "dept"){
          layer.setStyle({
            fillColor: 'transparent'
          })
        }else{
          layer.setStyle(styleDepartement());
        }
      }
      if(mapInsee.getZoom() < zoomDepartement){
        if(layer.feature.properties.zone !== "region"){
          layer.setStyle({
            fillColor: 'transparent'
          })
        }else {
          layer.setStyle(styleRegion());
        }
      }

    })
  }

  /**
  * Load data geoJson in function of zoom level
  */

  function loadGeoJson(){
    //TODO clean map before add new layer
    // if(mapInsee.getZoom() > zoomDefault){
      mygeojson = L.geoJSON(
        geoJsonFeatures,
        {
          style: style,
          onEachFeature: onEachFeature
        }
      ).addTo(mapInsee);
  }



  var mapInsee = mapjs.create('map-insee', {gestureHandling: true})
  mapInsee.setView(markerPoint, 13);

  loadGeoJson();
  mapInsee.on("zoom", displayFeature);

  L.marker(markerPoint).addTo(mapInsee)
      .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
      .openPopup();
</script>
