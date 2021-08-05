import './scss/styles.scss';

import { mapjs } from '../../public/js/map.js'
import * as L from 'leaflet';
import 'leaflet.markercluster';
import { GestureHandling } from 'leaflet-gesture-handling';

L.Icon.Default.imagePath = '/';
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'images/marker-icon-2x.png',
    iconUrl: 'images/marker-icon.png',
    shadowUrl: 'images/marker-shadow.png'
});

import Chart from 'chart.js';

import bulmaCarousel from 'bulma-carousel/dist/js/bulma-carousel.min.js';
const carousels = bulmaCarousel.attach('.carousel', {
  navigation: false,
  slidesToScroll: 1,
  slidesToShow: 1
});

import { animateValue } from '../../public/js/animate.js';
var values = document.querySelectorAll(".animate-value")
values.forEach(function (v) {
    animateValue(v)
})

window.onload = (event) => {
    if (document.getElementById('mapid')) {
        var homemap = mapjs.create('mapid', {gestureHandling: true})
        var markersCluster = L.markerClusterGroup();
        var groupMarker = [];
        var markerIcon = L.divIcon({
            className: 'leaflet-marker-icon leaflet-zoom-animated leaflet-interactive marker-icon-custom',
            html: "<div><span>1</span></div>",
            iconSize: [40, 40],
        });

        point.forEach(function (item, index) {
            var marker = L.marker(item, {icon: markerIcon}).bindPopup(popupviews[index]);
            groupMarker.push(marker);
            markersCluster.addLayer(marker);
        });

        if (markersCluster.getChildCount() > 0) {
            homemap.addLayer(markersCluster);
            var featureGroup = L.featureGroup(groupMarker);
            homemap.fitBounds(featureGroup.getBounds());
        }
    }

    var values = document.querySelectorAll(".animate-value")
    values.forEach(function (v) {
        animateValue(v)
    })

    document.querySelectorAll("div.map-place").forEach(nodeMap => {
        var id = nodeMap.getAttribute("id");
        var mapnode = document.getElementById(id);
        var namePlace = id.replace("map_", '');
        if (!geoDataPlace[namePlace]) {
            console.log(namePlace+" not found ("+id+")");
            return;
        }
        var latLon = [geoDataPlace[namePlace].geo.lat, geoDataPlace[namePlace].geo.lon];
        var mapPlace = mapjs.create(id, {
            gestureHandling: false,
            minZoom: 9,
            maxZoom: 9,
            zoomControl: false
        })
        L.marker(latLon).addTo(mapPlace)
        mapPlace.setView(latLon, 9)
        mapPlace.dragging.disable()
    })

    if (document.getElementById('section-map')) {
        var mapplace = mapjs.create('section-map', {gestureHandling: true})
        L.marker([placeLatLon.lat, placeLatLon.lon]).addTo(mapplace)
        mapplace.setView([placeLatLon.lat, placeLatLon.lon], 9)
    }

    if (document.getElementById('map-insee')) {
      var markerPoint = new L.LatLng(geoDataPlace.lat, geoDataPlace.lon);
      var mapInsee = mapjs.create('map-insee', {gestureHandling: true})
      mapInsee.setView(markerPoint, zoomDefault);

      var myIcon = L.icon({
        iconUrl: "/images/marker-icon.png",
        iconSize: [0, 0],
      });

      var select = document.getElementById("selectGeo");

      /**
       * Load data geoJson in function of zoom level
       */
      function loadGeoJson(zone){
        mygeojson = L.geoJSON(
          geoJsonFeatures[zone],
          {
            style: styleObjet,
            onEachFeature: onEachFeature
          }
        ).addTo(mapInsee);
      }

      function onEachFeature(feature, layer) {
        if(marker === undefined){
          marker = L.marker(markerPoint, {icon: myIcon}).addTo(mapInsee)
            .bindPopup("<div><h3 class='font-color-theme'>"+placeName+"</h3>"
              +"<h4>"+address.city+"("+address.postalcode.slice(0,2)+")</h4></div>")
            .openPopup();
        }
      }

      select.addEventListener('change', function (event) {
        var zone = event.target.value;
        actifChart.updateOptions(
          {
            xaxis: {
              categories:['Niveau national','Niveau '+zone]
            },
          }
        );
        cspChart.updateOptions(
          {
            xaxis: {
              categories:['Niveau national','Niveau '+zone]
            },
          }
        );
        immobilierChart.updateOptions(
          {
            xaxis: {
              categories:['Niveau national','Niveau '+zone]
            },
          }
        );

        var currentDataZone = placeData.insee[zone];
        setCaptionDataBar(currentDataZone, zone);
        setInseeChartData(currentDataZone,zone);
        mygeojson.remove();
        loadGeoJson(zone)
        mapInsee.fitBounds(mygeojson.getBounds())
      }, false)

      loadGeoJson(starting_zone);
      mapInsee.fitBounds(mygeojson.getBounds())
    }

    if(document.getElementById('data_territoire')) {
        actifChart.render();
        cspChart.render();
        immobilierChart.render();

        setCaptionDataBar(placeData.insee.iris, "iris");
        setInseeChartData(placeData.insee.iris,"iris")
        animateBar();
    }
}
