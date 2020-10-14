import './scss/styles.scss';

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
import './js/tabs.js';

import bulmaCarousel from 'bulma-carousel/dist/js/bulma-carousel.min.js';
const carousels = bulmaCarousel.attach('.carousel', {
  slidesToScroll: 1,
  navigationKeys:false,
  slidesToShow: 1,
  loop:true,
});
