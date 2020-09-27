var charts = (function () {
    var options = {}

    var charts = [];

    var canvas = document.querySelectorAll('canvas');

    function _search(id) {
        for (var el of canvas.entries()) {
            if (el[1].id === id) {
                return el[1];
            }
        }
        return 'undefined';
    }

    function create(chart, type, labels, data, colors, options ) {
        var ctx = _search(chart)

        if (typeof ctx === 'undefined') {
            ctx = document.querySelector('#'.chart);
        }

        var chart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets:  data
            },
            options: options

        });

        charts.push(chart);
    }

    function update(chart, data) {

    }

    return {
        create: create,
        update: update
    }
})();
