<script>
  var geoDataPlace = JSON.parse("{{ json_encode($place->geo) }}".replace(/&quot;/g,'"'));
  var placeData = JSON.parse("{{ json_encode($place->data) }}".replace(/&quot;/g,'"'));
  var address = @json($place->address);
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
  styleObjet = {
          fillColor: '#f37736',
          weight: 0,
          opacity: 2,
          color: 'white',
          fillOpacity: 0.3
      };

  /**
  *
  **/
  var myIcon = L.icon({
            iconUrl: "/images/marker-icon.png",
            iconSize: [0, 0],
        });
  function onEachFeature(feature, layer) {
    if(marker === undefined){

      marker = L.marker(markerPoint, {icon: myIcon}).addTo(mapInsee)
          .bindPopup("<div><h3 class='font-color-theme'>{{ $place->name }}</h3>"
          +"<h4>"+address.city+"("+address.postalcode.slice(0,2)+")</h4></div>")
          .openPopup();
    }
  }

  /**
  * Load data geoJson in function of zoom level
  */

  function loadGeoJson(){
    //TODO clean map before add new layer
    // if(mapInsee.getZoom() > zoomDefault){
      mygeojson = L.geoJSON(
        geoJsonFeatures.iris,
        {
          style: styleObjet,
          onEachFeature: onEachFeature
        }
      ).addTo(mapInsee);


  }



  var mapInsee = mapjs.create('map-insee', {gestureHandling: true})
  mapInsee.setView(markerPoint, zoomDefault);

  loadGeoJson();
  mapInsee.fitBounds(mygeojson.getBounds())
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
        style: styleObjet,
        onEachFeature: onEachFeature
      }
    ).addTo(mapInsee);
    mapInsee.fitBounds(mygeojson.getBounds())
  }, false)


</script>
