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

        data[0].backgroundColor = colors

        var chart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets:  data
            },
            options: options

        });

        charts.push(chart);
        return chart;
    }

    function update(chart, label, data) {
      chart.data.labels.push(label);
      chart.data.datasets.forEach((dataset) => {
          dataset.data.push(data);
      });
      chart.update();
    }

    return {
        create: create,
        update: update
    }
})();
