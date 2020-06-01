function animateValue(obj) {
    var end = parseInt(obj.innerHTML);
    var start = 1;
    var duration = 700;
    var range = end - start;
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

window.onload(
    animateValue(document.getElementById("animate-place")),
    animateValue(document.getElementById("animate-city")),
);
