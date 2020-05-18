var map = L.map('mapid').setView([48.8534100, 2.3488000], 13)

L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}{r}.png', {
    attribution: '<a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>',
    maxZoom: 19,
    minZoom: 1
}).addTo(map)
