<script type="text/javascript">
  const tooltip_id = 'tooltip-waffle';
  const svg_id = 'svg#waffle';

  let waffle_structure_data = {
    'entreprise': {{ $place->get('blocs->composition->donnees->type->Entreprises') ?: 0 }},
    'associations': {{ $place->get('blocs->composition->donnees->type->Associations') ?: 0 }},
    'artistes': {{ $place->get('blocs->composition->donnees->type->Artistes') ?: 0 }},
    'autres': {{ $place->get('blocs->composition->donnees->type->Autres structures') ?: 0 }}
  }
  let waffle_structure_text = {
    'entreprise': ' entreprises',
    'associations': ' associations',
    'artistes': ' artistes',
    'autres': ' autres'
  }
  let waffle_structure_color = {
    'entreprise': d3.rgb('#deebee'),
    'associations': d3.rgb('#ff5728'),
    'artistes': d3.rgb('#1abc9c'),
    'autres': d3.rgb('#96043e'),
    'empty': d3.rgb('white')
  }

  let waffle_data = [];
  for (let key of Object.keys(waffle_structure_data)) {
    for(let i = 0 ; i < waffle_structure_data[key] ; i++) {
      waffle_data.push(key);
    }
  }
  width = 500;
  carreau_num = Math.floor(Math.sqrt(waffle_data.length)) + 1;
  carreau_size = Math.floor(width / carreau_num);
  for(let i = waffle_data.length ; i < carreau_num * carreau_num ; i++) {
    waffle_data.push('empty');
  }

  waffle_data.reverse();

  d3.select('body')
    .append('div')
    .attr('id', tooltip_id)
    .attr('style', 'position: absolute; opacity: 0;');

  d3.select(svg_id)
    .selectAll('rect')
    .data(waffle_data)
    .enter()
    .append('rect')
    .attr('width', carreau_size - 2)
    .attr('height', carreau_size - 2)
    .attr('x', function(d, i) {
      if (Math.floor(i / carreau_num) % 2 ) {
        return (carreau_num - 1 - i % carreau_num) * carreau_size ;
      }
      return (i % carreau_num) * carreau_size ;
    })
    .attr('y', function(d, i) {return Math.floor(i / carreau_num) * carreau_size })
    .attr('fill', function(d) {if (waffle_structure_color[d]) {return waffle_structure_color[d]} return 'white';} )
    .attr('class', function(d) {return 'waffle_'+d; })
    .on("mouseover", function(d) {
      d3.selectAll('.waffle_'+d)
        .attr('fill', waffle_structure_color[d].brighter())
      ;
      console.log(!isNaN(waffle_structure_data[d]) * 1);
      d3.select('#'+tooltip_id)
        .style('opacity', ! isNaN(waffle_structure_data[d]) * 1 )
        .text( function(a) {
          if (waffle_structure_data[d])
            return waffle_structure_data[d]+waffle_structure_text[d];
        })
    } )
    .on('mousemove', function(d) {
      d3.select('#'+tooltip_id)
        .style('left', (d3.event.pageX + 25) + 'px')
        .style('top', (d3.event.pageY + 25) + 'px')
    })
    .on("mouseout", function(d) {
      d3.selectAll('.waffle_'+d)
        .attr('fill', waffle_structure_color[d])
      d3.select('#'+tooltip_id)
        .style('opacity', 0);
    } )
</script>


