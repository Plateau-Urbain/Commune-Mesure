var charts = (function () {
    var options = {}

    var colors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    }

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

    function create(chart, type, labels, data) {
        var ctx = _search(chart)

        if (typeof ctx === 'undefined') {
            ctx = document.querySelector('#'.chart);
        }

        var chart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: data
            }
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
