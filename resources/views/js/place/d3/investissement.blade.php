<script type="text/javascript">
  const svg_investissement_id = 'svg#investissement-graph'
  const svg = d3.select('svg')

  const parea_data = [
      {name: "Fonds privés", value: {{ $place->get('blocs->moyens->donnees->investissement->Fonds privés') ?: 0 }}},
      {name: "Fonds propres", value: {{ $place->get('blocs->moyens->donnees->investissement->Fonds apportés') ?: 0 }}},
      {name: "Fonds publics", value: {{ $place->get('blocs->moyens->donnees->investissement->Fonds publics') ?: 0 }}}
  ]

  const width = svg.node().getBoundingClientRect().width;
  const height = svg.node().getBoundingClientRect().height;
  const total = parea_data.reduce((accum, item) => accum + item.value, 0);

  color.domain(parea_data.map(d => d.name))

  parea_data.forEach(function (element, index) {
      element['pc'] = element.value / total
      element['id'] = index
      element['width'] = height * element['pc'];
      element['height'] = height * element['pc'];
  })

  parea_data[0]['x'] =  10;
  parea_data[0]['y'] =  height - height * parea_data[0]['pc'];
  parea_data[1]['x'] = 20 + height * parea_data[0]['pc'];
  parea_data[1]['y'] = height - height * parea_data[1]['pc'];
  parea_data[2]['x'] = parea_data[1]['x'];
  parea_data[2]['y'] = - 10 + parea_data[1]['y'] - height * parea_data[2]['pc'] ;

  d3.select(svg_investissement_id)
    .selectAll('rect')
    .data(parea_data)
    .enter()
    .append('rect')
    .attr('x', function(d) { return d.x})
    .attr('y', function(d) { return d.y})
    .attr('width', function(d) { return d.width})
    .attr('height', function(d) { return d.height})
    .attr('fill', function(d) { return color(d.name)})

  let texts = d3.select(svg_investissement_id)
    .selectAll('text')
    .data(parea_data)
    .enter()
    .append('text');

  texts.append('tspan')
    .attr('x', function(d) { return d.x + 10 })
    .attr('y', function(d) { return d.y + 20 })
    .attr('fill', 'white')
    .text(function(d) { return d.value + ' €'})
  texts.append('tspan')
    .attr('x', function(d) { return d.x + 10 })
    .attr('y', function(d) { return d.y + 40 })
    .attr('fill', 'white')
    .text(function(d) { return d.name })
</script>

