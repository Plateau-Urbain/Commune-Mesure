import './scss/external.scss';

import * as L from 'leaflet';
import 'leaflet.markercluster';
import { GestureHandling } from 'leaflet-gesture-handling';

L.Icon.Default.imagePath = '/';
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'images/marker-icon-2x.png',
    iconUrl: 'images/marker-icon.png',
    shadowUrl: 'images/marker-shadow.png'
});

import { mapjs } from '../../public/js/map.js'
import { animateValue } from '../../public/js/animate.js'

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

        if (point.length > 0) {
            homemap.addLayer(markersCluster);
            var featureGroup = L.featureGroup(groupMarker);
            homemap.fitBounds(featureGroup.getBounds());
        } else {
            homemap.setView(L.latLng(0,0), 1);
        }
    }

    var values = document.querySelectorAll(".animate-value")
    values.forEach(function (v) {
        animateValue(v)
    })
}
