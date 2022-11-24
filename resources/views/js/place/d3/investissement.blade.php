<script type="text/javascript">
  const svg_investissement_id = 'svg#investissement-graph'
  const svg = d3.select(svg_investissement_id)

  if (svg.node() === null) {
    throw new Error('No investissement graph');
  }

  const parea_data = [
      {name: "Fonds publics", value: {{ $place->get('blocs->moyens->donnees->investissement->Fonds publics') ?: 0 }}},
      {name: "Fonds privés", value: {{ $place->get('blocs->moyens->donnees->investissement->Fonds privés') ?: 0 }}},
      {name: "Fonds propres", value: {{ $place->get('blocs->moyens->donnees->investissement->Fonds apportés') ?: 0 }}}
  ]

  parea_data.sort((a,b) => b.value >= a.value);

  const graph_width = svg.node().getBoundingClientRect().width;
  const graph_height = svg.node().getBoundingClientRect().height - 50;
  const total = parea_data.reduce((accum, item) => accum + item.value, 0);
  var bloc_margin = 10

  color.domain(parea_data.map(d => d.name))

  parea_data.forEach(function (element, index) {
      element['pc'] = element.value / total
      // Proportion par rapport au plus gros
      element['pc2'] = element['pc'] / parea_data[0]['pc']
      element['id'] = index
      if (index == 0) {
        element['x'] = 0;
        if(element['width'] == 0 && element['height'] == 0){
          bloc_margin = 0
        }
      } else {
        element['x'] = bloc_margin + parea_data[index -1]['x'] + parea_data[index -1]['width'];
      }

      element['y'] = graph_height - (graph_height * element['pc2'])
      // Le plus gros prend toute la hauteur, les autres sont dimensionnés en fonction du plus gros
      element['height'] = graph_height * element['pc2'];
      // Parce que c'est ui carré...
      element['width'] = element['height'];
  })

  const tooltip_invest_id = 'tooltip-invest';

  d3.select('body')
    .append('div')
    .attr('id', tooltip_invest_id)
    .attr('class', 'd3_tooltip')
    .attr('style', 'position: absolute; opacity: 0;');

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
    .on("mouseover", function(d) {
      d3.select('#'+tooltip_invest_id)
        .style('opacity', ! isNaN(d.value) * 1 )
        .text( function(a) {
          if (d.value)
            return d.name+' : '+Math.round(d.pc * 100)+' %';
        })
    } )
    .on('mousemove', function(d) {
      d3.select('#'+tooltip_invest_id)
        .style('left', (d3.event.pageX + 25) + 'px')
        .style('top', (d3.event.pageY + 25) + 'px')
    })
    .on("mouseout", function(d) {
      d3.select('#'+tooltip_invest_id)
        .style('opacity', 0);
    } )


  let texts = d3.select(svg_investissement_id)
    .selectAll('text')
    .data(parea_data)
    .enter()
    .append('text');

  texts.append('tspan')
    .attr('x', function(d) { return d.x + 10 })
    .attr('y', function(d) { return d.y + 20 })
    .attr('fill', 'black')
    .text(function(d) { if (d.width > 30)  return Math.round(d.pc * 100) + ' %'})
  texts.append('tspan')
    .attr('x', function(d) { return d.x + 10 })
    .attr('y', function(d) { return d.y + 40 })
    .attr('fill', 'black')
    .text(function(d) { if (d.width > 100) return d.name })

  const legend_inv = d3.select(svg_investissement_id)
    .selectAll('g')
    .data(parea_data)
    .enter().append('g')

  const legend_inv_cicle = legend_inv.append('rect')
    .attr('width', 10).attr('height', 10).attr('y', -5).attr('x', -5)
    .attr('fill', function(d) { return color(d.name)})

  const legend_inv_text = legend_inv.append("text")
  .text(function(d) { return d.name })
    .attr('y', 4)
    .attr('dx', 10)
    .attr("text-anchor", 'left')
    .style("alignment-baseline", "middle")
    .style("font-size", '12px')

    const legends_inv_width_start = 0
    const legends_inv_height_start = graph_height  + 30

    legend_inv.each(function () {
      el = d3.select(this)

      el.attr('transform', function () {
        const translate = 'translate(%x%,%y%)'
        const prev = this.previousSibling
        if ( prev instanceof SVGTextElement ){
          legends_width = legends_inv_width_start
          legends_height = legends_inv_height_start
          return translate.replace('%x%', 10).replace('%y%', legends_height)
        }

        const bounds = d3.select(prev).node().getBBox()
        legends_width += bounds.width + 15
        const w = graph_width
        if (legends_width + d3.select(this).node().getBBox().width > w) {
          legends_width = legends_inv_width_start
          legends_height += 20
        }
        return translate.replace('%x%', 10+legends_width).replace('%y%', legends_height)
      })
    })
</script>
