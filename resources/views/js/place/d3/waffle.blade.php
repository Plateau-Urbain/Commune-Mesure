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
  carreau_size = Math.floor(height_waffle / carreau_num);

  Object.keys(waffle_structure).forEach(function (k) {
    const a = Array(waffle_structure[k].data).fill(k, 0)
    waffle_data.push(...a)
  })

  for(let i = total_structures ; i < carreau_num * carreau_num ; i++) {
    waffle_data.push('empty');
  }

  waffle_data.reverse();

  d3.select('body')
    .append('div')
    .attr('id', tooltip_waffle_id)
    .attr('style', 'position: absolute; opacity: 0;');

  center_x = Math.floor(( width_waffle - carreau_num * carreau_size ) / 2);

  svg_waffle.selectAll('rect')
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
        .style('opacity', ! isNaN(waffle_structure[d].data) * 1 )
        .text( function(a) {
          if (waffle_structure[d])
            return waffle_structure[d].data+' '+waffle_structure[d].text;
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
    } )
</script>
