<script>
  var geoDataPlace = JSON.parse("{{ json_encode($place->geo) }}".replace(/&quot;/g,'"'));
  var placeData = JSON.parse("{{ json_encode($place->data) }}".replace(/&quot;/g,'"'));
  var geoJsonFeatures = geoDataPlace.geo_json;
  var markerPoint = [geoDataPlace.lat, geoDataPlace.lon];

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
  var chartMap;
  var dataChartMap;
  var zone;

  /**
  * Css style default
  **/
  function style(){
      return {
          fillColor: '#f37736',
          weight: 0,
          opacity: 2,
          color: 'white',
          fillOpacity: 0.3
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

  function styleCommune(){
    return {
        fillColor: '#fdf498',
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
    if(mapInsee.getZoom() < zoomDefault){
      layer.setStyle({
        fillColor: 'transparent'
      })
    }
    if(marker === undefined){
      marker = L.marker(markerPoint).addTo(mapInsee)
          .bindPopup("<div><h3>Nom: {{ $place->name }}</h3>"
          +"<h4>Quartier: "+layer.feature.properties.nom+"</h4><p>"+layer.feature.properties.citycode+"</p></div>")
          .openPopup();
    }
  }

  function displayFeature(zoom) {

    var color = '#3d1e6d';
    var bounds;
    mygeojson.getLayers().forEach(function (layer) {
      if(mapInsee.getZoom() > zoomIris && mapInsee.getZoom() < zoomDefault){
        if(layer.feature.properties.zone !== "iris"){
          layer.setStyle({
            fillColor: 'transparent'
          })
        }else{
          layer.setStyle(style());

          zone = layer.feature.properties.zone;

        }
      }
      if(mapInsee.getZoom() <= zoomIris && mapInsee.getZoom() >= zoomCommune){
        if(layer.feature.properties.zone !== "commune"){
          layer.setStyle({
            fillColor: 'transparent'
          })
        }else{
          layer.setStyle(styleCommune());
          zone = layer.feature.properties.zone;
        }
      }
      if(mapInsee.getZoom() <= zoomCommune && mapInsee.getZoom() >= zoomDepartement){
        if(layer.feature.properties.zone !== "departement"){
          layer.setStyle({
            fillColor: 'transparent'
          })
        }else{
          layer.setStyle(styleDepartement());
          zone = layer.feature.properties.zone;
        }
      }
      if(mapInsee.getZoom() < zoomDepartement){
        if(layer.feature.properties.zone !== "region"){
          layer.setStyle({
            fillColor: 'transparent'
          })
        }else {
          layer.setStyle(styleRegion());
          zone = layer.feature.properties.zone;
        }
      }

    })
    animateBar();
    //delete placeData.insee[zone].population.total;
    // chartMap.data.labels = Object.keys(placeData.insee[zone].population);
    // chartMap.data.datasets[0].data = Object.values(placeData.insee[zone].population);
    //
    // chartMap.update()

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
  mapInsee.setView(markerPoint, zoomDefault);

  loadGeoJson();
  mapInsee.on("zoom", displayFeature);
</script>
