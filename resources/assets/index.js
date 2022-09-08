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

import bulmaCarousel from 'bulma-carousel/dist/js/bulma-carousel.min.js';

import './images/Commune-Mesure-1.png'

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
        const zone = event.target.value;

        mygeojson.remove();
        loadGeoJson(zone)
        mapInsee.fitBounds(mygeojson.getBounds())
      }, false)

      loadGeoJson(starting_zone);
      mapInsee.fitBounds(mygeojson.getBounds())
    }

    const carousels = bulmaCarousel.attach('.carousel', {
      navigation: false,
      slidesToScroll: 1,
      slidesToShow: 1
    });
}

document.addEventListener('DOMContentLoaded', () => {

    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach( el => {
            el.addEventListener('click', () => {

                // Get the target from the "data-target" attribute
                const target = el.dataset.target;
                const $target = document.getElementById(target);

                // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                el.classList.toggle('is-active');
                $target.classList.toggle('is-active');

            });
        });
    }

    // Ajout des liens du menu dans le menu mobile
    const menuItemsLi = document.querySelectorAll('#top-menu > li.menu-item');
    const menuMobile = document.getElementById('nav-mobile');

    menuItemsLi.forEach( li => {
        const link = li.querySelector('a').cloneNode(true)
        link.classList.add('navbar-item')

        if (li.classList.contains('menu-item-has-children')) {
            const dropdown = document.createElement('div')
            dropdown.classList.add('navbar-item', 'has-dropdown', 'is-active')

            link.classList.remove('navbar-item')
            link.classList.add('navbar-link', 'is-arrowless')
            dropdown.appendChild(link)

            const submenu = document.createElement('div')
            submenu.classList.add('navbar-dropdown')

            li.querySelectorAll('.sub-menu a').forEach( a => {
                const aMobile = a.cloneNode(true)
                aMobile.classList.add('navbar-item')
                submenu.appendChild(aMobile)
            })

            dropdown.appendChild(submenu)
            menuMobile.firstElementChild.appendChild(dropdown)
        } else {
            menuMobile.firstElementChild.appendChild(link);
        }
    });
});
