function animateValue(obj) {
    var end = parseInt(obj.dataset.total);
    var start = 0;
    var range = end - start;
    var duration = 2000;

    var interval = duration / end

    if (range > 0) {
        var current = start;
        var increment = end > start? 1 : -1;
        var timer = setInterval(function() {
            current += increment;
            obj.innerHTML = current;
            if (parseInt(current) == parseInt(end)) {
                clearInterval(timer);
            }
        }, Math.abs(interval));
    }
}

window.onload = (event) => {
    var values = document.querySelectorAll(".animate-value")
    values.forEach(function (v) {
        animateValue(v)
    })
}
