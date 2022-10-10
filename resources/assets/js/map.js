export const mapjs = (function () {
    const config = {
        layer: 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png',
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributeurs'
    }

    function create(id, options) {
        const map = L.map(id, options)

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
