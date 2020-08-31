<script>
function loadCompare(selector, nbPoint){
  var data    = [], min = max = 10;
  var origin  = [80, 80], startAngle = Math.PI/8, beta = startAngle;
  d3.select(selector).html("");
  var svg     = d3.select(selector).call(d3.drag().on('drag', dragged).on('start', dragStart).on('end', dragEnd)).append('g');
  var color   = d3.scaleOrdinal(d3.schemeCategory10);
  var rn      = function(min, max){ return Math.round(d3.randomUniform(min, max + 1)()); };
  var mx, mouseX;

  for (var i = nbPoint; i >= 0; i--) {
      data.push({
          x: rn(-min, max),
          y: rn(-min, max),
          z: rn(-min, max)
      });
  }

  var _3d = d3._3d()
      .scale(5)
      .origin(origin)
      .rotateX(startAngle)
      .rotateY(startAngle)
      .primitiveType('POINTS');

  var data3D  = _3d(data);
  var extentZ = d3.extent(data3D, function(d){ return d.rotated.z });
  var zScale  = d3.scaleLinear().domain([extentZ[1]+10, extentZ[0]-10]).range([1, 8]);

  function dragStart(){
      mx = d3.event.x;
  }

  function dragged(){
      mouseX = mouseX || 0;
      beta   = (d3.event.x - mx + mouseX) * Math.PI / 360 * (-1);
      processData(_3d.rotateY(beta + startAngle)(data));
  }

  function dragEnd(){
      mouseX = d3.event.x - mx + mouseX;
  }

  function processData(data){

      var points = svg.selectAll('circle').data(data);

      points
          .enter()
          .append('circle')
          .merge(points)
          .attr('fill',   function(d, i){ return color(i); })
          .attr('stroke', function(d, i){ return d3.color(color(i)).darker(0.5); })
          .sort(function(a, b){    return d3.descending(a.rotated.z, b.rotated.z); })
          .attr('cx', function(d){ return d.projected.x; })
          .attr('cy', function(d){ return d.projected.y; })
          .attr('r' , function(d){ return zScale(d.rotated.z); });

      points.exit().remove();
  }

  processData(data3D);
}

</script>
