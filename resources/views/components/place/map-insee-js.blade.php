<script>
  var geoDataPlace = JSON.parse("{{ json_encode($place->geo) }}".replace(/&quot;/g,'"'));
  var placeData = JSON.parse("{{ json_encode($place->data) }}".replace(/&quot;/g,'"'));
  var geoJsonFeatures = geoDataPlace.geo_json;
  var markerPoint = new L.LatLng(geoDataPlace.lat, geoDataPlace.lon);

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
  var styleObjet = {};

  /**
  * Css style default
  **/
  styleObjet["iris"] = {
          fillColor: '#f37736',
          weight: 0,
          opacity: 2,
          color: 'white',
          fillOpacity: 0.3
      };

  /**
  * Css style departement
  **/
  styleObjet["departement"] = {
      fillColor: '#d0f3fb',
      weight: 0,
      opacity: 2,
      color: 'white',
      fillOpacity: 0.7
  };

  styleObjet["commune"] = {
      fillColor: '#fdf498',
      weight: 0,
      opacity: 2,
      color: 'white',
      fillOpacity: 0.7
  };

  /**
  * Css style region
  * //TODO opacity light
  **/
  styleObjet['region'] = {
      fillColor: '#3d1e6d',
      weight: 0,
      opacity: 2,
      color: 'white',
      fillOpacity: 0.7
  }


  /**
  *
  **/
  var myIcon = L.icon({
            iconUrl: window.location.origin +"/images/marker-icon.png",
            iconSize: [32, 32],
            iconAnchor: [16,32]
        });
  function onEachFeature(feature, layer) {
    if(marker === undefined){

      marker = L.marker(markerPoint, {icon: myIcon}).addTo(mapInsee)
          .bindPopup("<div><h3>Nom: {{ $place->name }}</h3>"
          +"<h4>Quartier: "+layer.feature.properties.nom+"</h4><p>"+layer.feature.properties.citycode+"</p></div>")
          .openPopup();
    }
  }

  // function displayFeature(zoom) {
  //
  //   var color = '#3d1e6d';
  //   var bounds;
  //   mygeojson.remove();
  //   if(mapInsee.getZoom() > zoomIris && mapInsee.getZoom() < zoomDefault){
  //     mygeojson = L.geoJSON(
  //       geoJsonFeatures.iris,
  //       {
  //         style: styleObjet.iris,
  //         onEachFeature: onEachFeature
  //       }
  //     ).addTo(mapInsee);
  //   }
  //   if(mapInsee.getZoom() <= zoomIris && mapInsee.getZoom() >= zoomCommune){
  //     mygeojson = L.geoJSON(
  //       geoJsonFeatures.commune,
  //       {
  //         style: styleObjet.commune,
  //         onEachFeature: onEachFeature
  //       }
  //     ).addTo(mapInsee);
  //   }
  //   if(mapInsee.getZoom() < zoomCommune && mapInsee.getZoom() >= zoomDepartement){
  //     mygeojson = L.geoJSON(
  //       geoJsonFeatures.commune,
  //       {
  //         style: styleObjet.departement,
  //         onEachFeature: onEachFeature
  //       }
  //     ).addTo(mapInsee);
  //   }
  //   if(mapInsee.getZoom() < zoomDepartement){
  //     mygeojson = L.geoJSON(
  //       geoJsonFeatures.region,
  //       {
  //         style: styleObjet.region,
  //         onEachFeature: onEachFeature
  //       }
  //     ).addTo(mapInsee);
  //   }
  //   //mapInsee.fitBounds(mygeojson.getBounds())
  //   animateBar();
  //   //delete placeData.insee[zone].population.total;
  //   // chartMap.data.labels = Object.keys(placeData.insee[zone].population);
  //   // chartMap.data.datasets[0].data = Object.values(placeData.insee[zone].population);
  //   //
  //   // chartMap.update()
  //
  // }

  /**
  * Load data geoJson in function of zoom level
  */

  function loadGeoJson(){
    //TODO clean map before add new layer
    // if(mapInsee.getZoom() > zoomDefault){
      mygeojson = L.geoJSON(
        geoJsonFeatures.iris,
        {
          style: styleObjet.iris,
          onEachFeature: onEachFeature
        }
      ).addTo(mapInsee);

  }



  var mapInsee = mapjs.create('map-insee', {gestureHandling: true})
  mapInsee.setView(markerPoint, zoomDefault);

  loadGeoJson();
  //TODO other possibilities to make work displaying zoom
  //mapInsee.on("zoom", displayFeature);
  var select = document.getElementById("selectGeo");
  select.addEventListener('change', function (event) {
    var zone = event.target.value;
    var currentDataZone = placeData.insee[zone];
    setCaptionDataBar(currentDataZone, zone);
    setInseeChartData(currentDataZone,zone);
    mygeojson.remove();
    mygeojson = L.geoJSON(
      geoJsonFeatures[zone],
      {
        style: styleObjet[zone],
        onEachFeature: onEachFeature
      }
    ).addTo(mapInsee);
    mapInsee.fitBounds(mygeojson.getBounds())
    //Bar caption with new data
    animateBar();
  }, false)


</script>
