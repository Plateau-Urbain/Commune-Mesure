import './scss/styles.scss';

import * as L from 'leaflet';
import 'leaflet.markercluster';
import { GestureHandling } from 'leaflet-gesture-handling';

import icon from 'leaflet/dist/images/marker-icon.png';
import iconShadow from 'leaflet/dist/images/marker-shadow.png';

let DefaultIcon = L.icon({
    iconUrl: icon,
    shadowUrl: iconShadow
});

L.Marker.prototype.options.icon = DefaultIcon;

import Chart from 'chart.js';
import './js/tabs.js';
const sigma = require('sigma'); (window).sigma = sigma;

const sigmaParser = require('sigma/build/plugins/sigma.parsers.json.min.js'); (window).sigmaParser = sigmaParser;

import bulmaCarousel from 'bulma-carousel/dist/js/bulma-carousel.min.js';
const carousels = bulmaCarousel.attach('.carousel', {
  slidesToScroll: 1,
  navigationKeys:false,
  slidesToShow: 1,
  loop:true,
});
