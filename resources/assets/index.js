import './scss/styles.scss';

import { mapjs } from './js/map.js'
import * as L from 'leaflet';
import 'leaflet.markercluster';
import { gestureHandling } from 'leaflet-gesture-handling';

L.Icon.Default.imagePath = '/';
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'images/marker-icon-2x.png',
    iconUrl: 'images/marker-icon.png',
    shadowUrl: 'images/marker-shadow.png'
});

import bulmaCarousel from 'bulma-carousel/dist/js/bulma-carousel.min.js';
import './images/Commune-Mesure-1.png'
import { animateValue } from './js/animate.js';
import './js/sticky.js'

document.addEventListener('DOMContentLoaded', () => {
    // Carte page d'accueil
    if (document.getElementById('mapid')) {
        const homemap = mapjs.create('mapid', {gestureHandling: true})
        const markersCluster = L.markerClusterGroup();
        const groupMarker = [];
        const markerIcon = L.divIcon({
            className: 'leaflet-marker-icon leaflet-zoom-animated leaflet-interactive marker-icon-custom',
            html: "<div><span>1</span></div>",
            iconSize: [40, 40],
        });

        point.forEach(function (item, index) {
            const marker = L.marker(item, {icon: markerIcon}).bindPopup(popupviews[index]);
            groupMarker.push(marker);
            markersCluster.addLayer(marker);
        });

        if (point.length > 0) {
            homemap.addLayer(markersCluster);
            const featureGroup = L.featureGroup(groupMarker);
            homemap.fitBounds(featureGroup.getBounds());
        } else {
            homemap.setView(L.latLng(0,0), 1);
        }
    }

    var values = document.querySelectorAll(".animate-value")
    values.forEach(function (v) {
        animateValue(v)
    })

    // Carte d'un lieu
    if (document.getElementById('section-map')) {
        var mapplace = mapjs.create('section-map', {
            gestureHandling: false,
            dragging: false,
            scrollWheelZoom: false
        })
        L.marker([placeLatLon.lat, placeLatLon.lon]).addTo(mapplace)
        mapplace.setView([placeLatLon.lat, placeLatLon.lon], 9)
        mapplace.zoomControl.setPosition('topright')
    }


    const carousels_listing = bulmaCarousel.attach('.carousel-listing', {
        navigation: false,
        slidesToScroll: 1,
        slidesToShow: 1,
    });

    const carousels = bulmaCarousel.attach('.carousel', {
        navigation: false,
        slidesToScroll: 1,
        slidesToShow: 1,
        effect: 'fade',
        loop: true
    });

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

    // Cartes listing des lieux
    document.querySelectorAll("div.map-place").forEach(nodeMap => {
        var id = nodeMap.getAttribute("id");
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
});
