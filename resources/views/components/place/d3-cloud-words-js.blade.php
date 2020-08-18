<script>

  var activitiesMerits = JSON.parse("{{ json_encode($place->structure) }}".replace(/&quot;/g,'"'));
  var myActivities = activitiesMerits.activities;
  var myMerits = activitiesMerits.merits;

  var margin = {top: 10, right: 10, bottom: 10, left: 10},
  width = 500 - margin.left - margin.right,
  height = 450 - margin.top - margin.bottom;

  var svg = d3.select("#d3-cloud").append("svg")
  .attr("width", width + margin.left + margin.right)
  .attr("height", height + margin.top + margin.bottom)
  .append("g")
  .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
  var layout = d3.layout.cloud()
  .size([width, height])
  .words(myActivities.concat(myMerits).map(function(d) { return {text: d}; }))
  .padding(10)
  .fontSize(15)
  .on("end", draw);
  layout.start();
  function draw(words) {
  svg.append("g")
    .attr("transform", "translate(" + layout.size()[0] / 2 + "," + layout.size()[1] / 2 + ")")
    .selectAll("text")
    .data(words)
    .enter().append("text")
      .style("font-size", function(d) { return d.text.size + "px"; })
      .attr("text-anchor", "middle")
      .style("fill", function(d) { return d.text.color; })
      .attr("transform", function(d) {
        return "translate(" + [d.x, d.y] + ")";
      })
      .text(function(d) { return d.text.text; });
  }
</script>
