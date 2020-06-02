function animateValue(obj) {
    var end = parseInt(obj.dataset.total);
    var start = 0;
    var range = end - start;
    if (range > 0) {
        var duration = 700;
        var current = start;
        var increment = end > start? 1 : -1;
        var stepTime = Math.abs(Math.floor(duration / range));
        var timer = setInterval(function() {
            current += increment;
            obj.innerHTML = current;
            if (parseInt(current) == parseInt(end)) {
                clearInterval(timer);
            }
        }, stepTime);
    }
}

window.onload = (event) => {
    var values = document.querySelectorAll(".animate-value")
    values.forEach(function (v) {
        animateValue(v)
    })
}
