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
  var zoomIris = 13;
  var zoomCommune = 11;
  var zoomDepartement = 9;
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
          chartMap.data.labels = Object.keys(placeData.insee[zone].population);
          chartMap.data.datasets[0].data = Object.values(placeData.insee[zone].population);
          chartMap.update()
        }
      }
      if(mapInsee.getZoom() <= zoomIris && mapInsee.getZoom() >= zoomCommune){
        if(layer.feature.properties.zone !== "commune"){
          layer.setStyle({
            fillColor: 'transparent'
          })
        }else{
          layer.setStyle(styleCommune());
        }
      }
      if(mapInsee.getZoom() <= zoomCommune && mapInsee.getZoom() >= zoomDepartement){
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
  mapInsee.setView(markerPoint, zoomDefault);

  loadGeoJson();
  mapInsee.on("zoom", displayFeature);


  chartMap = new Chart(document.getElementById("bar-chart-horizontal"), {
    type: 'horizontalBar',
    data: {
      labels: ["Lieu-actif", "Iris-actif", "Lieu-logement", "Iris-logement", "Lieu-population", "Iris-population"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
          data: [2478,5267,734,784,433]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
  });
</script>
