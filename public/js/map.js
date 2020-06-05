var mapjs = (function () {
    var config = {
        layer: 'https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}{r}.png',
        attribution: '<a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
    }

    function create(id, options) {
        var map = L.map(id, options)

        L.tileLayer(config.layer, {
            attribution: config.attribution,
            maxZoom: 19,
            minZoom: 1
        }).addTo(map)

        return map
    }

    return {
        create: create
    };
})();
