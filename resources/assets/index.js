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

        homemap.addLayer(markersCluster);
        var featureGroup = L.featureGroup(groupMarker);
        homemap.fitBounds(featureGroup.getBounds());
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

}
