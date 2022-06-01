<script type="text/javascript">
  const svg_investissement_id = 'svg#investissement-graph'

  let parea_fond_data = [
    {{ $place->get('blocs->moyens->donnees->investissement->Fonds privés') ?: 0 }},
    {{ $place->get('blocs->moyens->donnees->investissement->Fonds apportés') ?: 0 }},
    {{ $place->get('blocs->moyens->donnees->investissement->Fonds publics') ?: 0 }}
  ]
  let parea_fond_name = [
    'Fonds privés',
    'Fonds propres',
    'Fonds publics',
  ]
  let width = 500;
  let height = 500;

  let total = 0;
  parea_data = [];
  for(let k in parea_fond_name) {
    total += parea_fond_data[k];
    parea_data.push({'name': parea_fond_name[k], 'value': parea_fond_data[k] });
  }
  parea_fond_data.sort();
  parea_fond_data.reverse();
  total -= parea_fond_data[0];

  for(let i = 0 ; i < parea_data.length ; i ++) {
    parea_data[i]['pc'] = parea_data[i]['value'] / total;
    parea_data[i]['id'] = i;
  }
  parea_data[0]['x'] =  10;
  parea_data[0]['y'] =  height - height * parea_data[0]['pc'];
  parea_data[0]['width'] =  height * parea_data[0]['pc'];
  parea_data[0]['height'] =  height * parea_data[0]['pc'];
  parea_data[0]['fill'] =  '#ff5728';
  parea_data[1]['x'] = 20 + height * parea_data[0]['pc'];
  parea_data[1]['y'] = height - height * parea_data[1]['pc'];
  parea_data[1]['width'] = height * parea_data[1]['pc'];
  parea_data[1]['height'] = height * parea_data[1]['pc'];
  parea_data[1]['fill'] = '#1abc9c';
  parea_data[2]['x'] = parea_data[1]['x'];
  parea_data[2]['y'] = - 10 + parea_data[1]['y'] - height * parea_data[2]['pc'] ;
  parea_data[2]['width'] = height * parea_data[2]['pc'];
  parea_data[2]['height'] = height * parea_data[2]['pc'];
  parea_data[2]['fill'] = '#96043e';

  d3.select(svg_investissement_id)
    .selectAll('rect')
    .data(parea_data)
    .enter()
    .append('rect')
    .attr('x', function(d) { return d.x})
    .attr('y', function(d) { return d.y})
    .attr('width', function(d) { return d.width})
    .attr('height', function(d) { return d.height})
    .attr('fill', function(d) { return d.fill})

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

