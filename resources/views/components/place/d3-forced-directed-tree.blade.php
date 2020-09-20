<script src="/js/enhances.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.9.2/d3.min.js"></script>
<script>
var aspect = .75;
const marginFixed = 104;
var margin = {
    top: marginFixed,
    right: marginFixed,
    bottom: marginFixed,
    left: marginFixed
};

// var width = parseFloat(((1200) - margin.left - margin.right));
// var height = ((aspect * width) - margin.top - margin.bottom);
// var svg = d3.select("#container")
//     .append("svg")
//     .attr("cursor", "crosshair")
//     .attr("width", width + margin.left + margin.right)
//     .attr("height", height + margin.top + margin.bottom)
//     .attr("id", "chart")
//     .attr("viewBox", (-width / 2) + "," + (-height / 2) + "," + width + "," + height)
//     .attr("preserveAspectRatio", "xMidYMid meet")
//     .attr("transform", "translate(0," + margin.top / 2 + ")");
//
// var labels = svg.append("g")
//     .attr("class", "labels")
//     .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
//
//Integrer bon json
var path = d3.json("/d3/data/family_tree_2.json").then(function(data) {

    const root = d3.hierarchy(data);
    const links = root.links();
    const nodes = root.descendants();
    console.log(root);
    var counted = root.copy().count();
    var summed = root.sum(d => d.value)
    var sum = root.copy().sum(d => 1).value

    var depthInt = [];
    root.each(d => depthInt.push(d.depth));

    var heightInt = [];
    root.each(d => heightInt.push(d.height));
    console.log(heightInt);

    var parseTime = d3.timeParse("%Y-%m-%dT%H:%M:%S");
    var today = new Date();

    var dobArr2 = [];
    root.each(d => dobArr2.push(parseInt((today - parseTime(d.data.dob)) / ((1000 * 3600 * 24) * (365)))));

	  var r = d3.scaleLinear()
        .domain(d3.extent(depthInt))
        .range([12, 4]);

    var t = d3.scalePow()
        .domain(d3.extent(dobArr2))
        .range([6, 30]);

    var col = d3.scaleLinear()
        .domain(d3.extent(depthInt))
        .range([80, 20]);

    var hue = d3.scaleLinear()
        .domain(d3.extent(depthInt))
        .range([300, 120]);

    const simulation = d3.forceSimulation(nodes)
        .force("link", d3.forceLink(links).id(d => d.id).distance(50).strength(1))
        .force("charge", d3.forceManyBody().strength(-300))
        .force("x", d3.forceX())
        .force("y", d3.forceY());

    const link = svg.append("g")
        .attr("stroke", "hsl(158, 0%, 27%)")
        .attr("stroke-opacity", 0.6)
        .selectAll("line")
        .data(links)
        .join("line");


    // Define the div for the tooltip
    var div = d3.select("#caption").append("div")
        .data(nodes)
        .attr("class", "tooltip")
        .style("opacity", 0);


    function mouseover() {
        div.transition()
            .duration(100)
            .style("opacity", 1);
        div.html($(this).attr('id'))
            .style("color", "#000000")
            .style("left", "0px")
            .style("top", "0px");
    }

    function mouseout() {
        div.transition()
            .duration(500)
            .style("opacity", 0);
    };

    const node = svg.append("g")
         //.attr("fill", "hsl(190, 67%, 20%)")
        .attr("stroke", "none")
        .attr("stroke-width", 3)
        .selectAll("circle")
        .data(nodes)
        .join("circle")
        .attr("id", (d, i) => d.data.name + " - " + d.height + " , " + d.depth + " ~ " + (parseInt((today - parseTime(d.data.dob)) / ((1000 * 3600 * 24) * (365)))))
        //.attr("fill", d => d.children ? null : "hsl(200, 100%, 40%)")
        //.attr("fill", d => "hsl(120, 80%, "+col(d.depth)+"%)")
        .attr("fill", d => "hsl("+hue(d.depth)+", 80%, 40%)")
        //.attr("fill", "#FFFFFF")
        //.attr("stroke", d => d.children ? null : "hsl(0, 100%, 32%)")
        .attr("stroke", "none")
        //.attr("r", d => r(d.depth))
        .attr("r", d => t(parseInt((today - parseTime(d.data.dob)) / ((1000 * 3600 * 24) * (365)))))
        .call(drag(simulation))
        .on("mouseover", mouseover)
        .on("mouseout", mouseout);

    node.append("title")
        .text(d => d.data.name);

    simulation.on("tick", () => {
        link
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);

        node
            .attr("cx", d => d.x)
            .attr("cy", d => d.y);
    });
    return svg.node();


})

const drag = simulation => {

    function dragstarted(d) {
        if (!d3.event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x;
        d.fy = d.y;
    }

    function dragged(d) {
        d.fx = d3.event.x;
        d.fy = d3.event.y;
    }

    function dragended(d) {
        if (!d3.event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
    }

    return d3.drag()
        .on("start", dragstarted)
        .on("drag", dragged)
        .on("end", dragended);
}

var chart = $("#chart"),
    aspect = chart.width() / chart.height(),
    container = chart.parent();
$(window).on("resize", function() {
    var targetWidth = container.width();
    chart.attr("width", targetWidth);
    chart.attr("height", Math.round(targetWidth / aspect));
}).trigger("resize");

</script>
