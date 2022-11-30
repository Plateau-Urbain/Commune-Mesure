<script type="text/javascript">
  const tooltip_waffle_id = 'tooltip-waffle';
  const svg_waffle = d3.select('svg#waffle')

  const width_waffle = svg_waffle.node().getBoundingClientRect().width;
  const height_waffle = svg_waffle.node().getBoundingClientRect().height - 100;

  const waffle_structure = {
    'entreprises': {
      'data': {{ $place->get('blocs->composition->donnees->type->Entreprises') ?: 0 }},
      'text': 'Entreprises'
    },
    'associations': {
      'data': {{ $place->get('blocs->composition->donnees->type->Associations') ?: 0 }},
      'text': 'Associations'
    },
    'artistes': {
      'data': {{ $place->get('blocs->composition->donnees->type->Artistes') ?: 0 }},
      'text': 'Artistes'
    },
    'autres': {
      'data': {{ $place->get('blocs->composition->donnees->type->Autres structures') ?: 0 }},
      'text': 'Autres'
    }
  }

  let waffle_data = [];
  let total_structures = Object.values(waffle_structure).reduce((acc, val) => acc + val.data, 0)

  color.domain(Object.keys(waffle_structure))
  carreau_num = Math.floor(Math.sqrt(total_structures)) + 1;
  if (height_waffle > width_waffle) { waffle_size = width_waffle } else { waffle_size = height_waffle }
  carreau_size = Math.floor(waffle_size / carreau_num);

  Object.keys(waffle_structure).forEach(function (k) {
    const a = Array(waffle_structure[k].data).fill(k, 0)
    waffle_data.push(...a)
  })
  
  for(let i = 0 ; i < carreau_num - total_structures % carreau_num ; i++) {
    waffle_data.push('empty');
  }

  waffle_data.reverse();

  d3.select('body')
    .append('div')
    .attr('id', tooltip_waffle_id)
    .attr('class', 'd3_tooltip')
    .attr('style', 'position: absolute; opacity: 0;');

  center_x = Math.floor(( width_waffle - carreau_num * carreau_size ) / 2);

  const rects = svg_waffle.append('g')

  rects.selectAll('rect')
    .data(waffle_data)
    .enter()
    .append('rect')
    .attr('width', carreau_size - 2)
    .attr('height', carreau_size - 2)
    .attr('x', function(d, i) {
      if (Math.floor(i / carreau_num) % 2) {
        return center_x + (carreau_num - 1 - i % carreau_num) * carreau_size;
      }
      return center_x + (i % carreau_num) * carreau_size;
    })
    .attr('y', function(d, i) {return Math.floor(Math.floor(i / carreau_num) * carreau_size) })
    .attr('fill', function(d) { if ([d]) return color(d) })
    .attr('opacity', function(d) { return ( d && (d != 'empty') && (waffle_structure[d]) && !isNaN(waffle_structure[d].data)) * 1; })
    .attr('class', function(d) {return 'waffle_'+d; })
    .on("mouseover", function(d) {
      d3.select('#'+tooltip_waffle_id)
        .style('opacity', typeof waffle_structure[d] !== 'undefined' && ! isNaN(waffle_structure[d].data) * 1 )
        .text( function(a) {
          if (waffle_structure[d]) {
            const t = (waffle_structure[d].data > 1) ? waffle_structure[d].text : waffle_structure[d].text.slice(0, waffle_structure[d].text.length - 1);
            return waffle_structure[d].data + ' ' + t
          }
        })
    } )
    .on('mousemove', function(d) {
      d3.select('#'+tooltip_waffle_id)
        .style('left', (d3.event.pageX + 25) + 'px')
        .style('top', (d3.event.pageY + 25) + 'px')
    })
    .on("mouseout", function(d) {
      d3.select('#'+tooltip_waffle_id)
        .style('opacity', 0);
    });

    const title = svg_waffle.append('g')

    waffle_rect = rects.node().getBoundingClientRect()
    waffle_height = waffle_rect.height
    waffle_width = waffle_rect.width

    title.attr('transform', 'translate(0,' + (waffle_height + 10) + ')')

    title_block = title.append('text')
      .attr('transform', 'translate(0, 40)')
      .attr('x', '50%')
      .attr('text-anchor', 'middle')
      .style('font-size', '1.35rem')
      .style('font-family', 'BlinkMacBlinkMacSystemFont, -apple-system, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serifSystemFont')
      .style('font-weight', 'bold')

    title_block.text('Type de structures')
    title_block.append('tspan').attr('x', '50%').attr('y', 25).attr('text-anchor', 'middle').text('participant au projet')

    const legends = svg_waffle.append('g')

    legends.attr('transform', 'translate(50,' + (waffle_height + 75) + ')')

    legends
      .selectAll('legend')
      .data(Object.keys(waffle_structure))
      .enter()
      .append('rect')
      .attr('width', 10).attr('height', 10)
      .attr('x', function(d, i) { return center_x + (i % 2)* width_waffle / 2.5 - 5})
      .attr('y', function(d, i) { return 30 * (1 + Math.floor( i / 2 )) - 10 })
      .attr('fill', d => color(d)); //function(d) { return color(d.name)})

    legends
      .selectAll('legend-text')
      .data(Object.keys(waffle_structure))
      .enter()
      .append('text')
      .attr('x', function(d, i) { return center_x + (i % 2)* width_waffle / 2.5 + 10})
      .attr('y', function(d, i) { return 30 * (1 + Math.floor( i / 2 )) })
      .attr('fill', 'black')
      .style('font-size', '12px')
      .text(function(d) { return waffle_structure[d].text; })

    waffle_global_svg_size = svg_waffle.node().attributes.getNamedItem('height');
    waffle_global_svg_size.value = svg_waffle.node().getBoundingClientRect().height + 30
</script>
