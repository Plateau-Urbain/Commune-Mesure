<script type="text/javascript">
  const svg_fonctionnement  = d3.select('svg#financement-budget-doughnut')

  if (svg_fonctionnement.node() === null) {
    throw new Error('No fonctionnement chart');
  }


  const fonctionnement_width  = svg_fonctionnement.node().getBoundingClientRect().width
  const fonctionnement_height = svg_fonctionnement.node().getBoundingClientRect().height

  const fonctionnement_margin = 50
  
  var translate_y_adjust = 0
  // La légende est sur deux lignes => on met plus d'espace pour ça
  if (fonctionnement_width < 430) {
    translate_y_adjust = -5
  }

  const fonctionnement_radius = Math.min(fonctionnement_width, fonctionnement_height) / 1.4 - fonctionnement_margin

  const tooltip_fonctionnement_id = 'tooltip-fonctionnement';

  d3.select('body')
    .append('div')
    .attr('id', tooltip_fonctionnement_id)
    .attr('class', 'd3_tooltip')
    .attr('style', 'position: absolute; opacity: 0;');

  const donut_data = [
    {name: "Aides publiques", count: {{ $place->get('blocs->moyens->donnees->fonctionnement->Aides publiques') }} },
    {name: "Aides privées", count: {{ $place->get('blocs->moyens->donnees->fonctionnement->Aides privées') }} },
    {name: "Recettes", count: {{ $place->get('blocs->moyens->donnees->fonctionnement->Recettes') }} },
    {name: "Autres subventions", count: {{ $place->get('blocs->moyens->donnees->fonctionnement->Autres Subventions') }} }
  ]
  color.domain(donut_data.map(d => d.name))

  const pieArcData = d3.pie()
    .value(d => d.count)(donut_data)
  const arc = d3.arc()
    .innerRadius(fonctionnement_radius * 0.5)
    .outerRadius(fonctionnement_radius * 0.8)
    .padRadius(200)
    .padAngle(12/300)

  svg_fonctionnement
    .attr('width', fonctionnement_width)
    .attr('height', fonctionnement_height)
    .append('g')
    .attr('id', 'piechart_fonctionnement')
    .attr("transform", "translate(" + (0 + fonctionnement_margin + (fonctionnement_radius / 2)) + "," + (fonctionnement_margin + translate_y_adjust + (fonctionnement_radius / 2)) + ")")
    .selectAll('path')
    .data(pieArcData)
    .enter()
    .append('path')
    .attr('d', (d) => arc(d))
    .attr('fill', (d) => color(d.data.name))
    .on("mouseover", function(d) {
      d3.select('#'+tooltip_fonctionnement_id)
        .style('opacity', ! isNaN(d.data.count) * 1 )
        .text( function(a) {
          if (d.data.count)
            return d.data.name+' : '+d.data.count+' €';
        })
    } )
    .on('mousemove', function(d) {
      d3.select('#'+tooltip_fonctionnement_id)
        .style('left', (d3.event.pageX + 25) + 'px')
        .style('top', (d3.event.pageY + 25) + 'px')
    })
    .on("mouseout", function(d) {
      d3.select('#'+tooltip_fonctionnement_id)
        .style('opacity', 0);
    } )

    const legends_pie = svg_fonctionnement.append('g')
      .selectAll('g')
      .data(pieArcData)
      .enter().append('g')

    const legend_pie_Circle = legends_pie.append('rect')
        .attr('width', 10).attr('height', 10).attr('y', -5).attr('x', -5)
        .attr('fill', function(d) { return color(d.data.name)})

    const legend_pie_Text = legends_pie.append('text')
      .text(function(d) { return d.data.name })
        .attr('y', 4)
        .attr('dx', 10)
        .attr("text-anchor", 'left')
        .style("alignment-baseline", "middle")
        .style("font-size", '12px')

    const legends_pie_width_start = 0
    const legends_pie_height_start = d3.select('#piechart_fonctionnement').node().getBBox().height + 30

    legends_pie.each(function () {
      el = d3.select(this)

      el.attr('transform', function () {
        const translate = 'translate(%x%,%y%)'
        const prev = this.previousSibling

        if (prev === null) {
          legends_width = legends_pie_width_start
          legends_height = legends_pie_height_start
          return translate.replace('%x%', 10).replace('%y%', legends_height)
        }
        const bounds = d3.select(prev).node().getBBox()
        legends_width += bounds.width + 15
        const w = fonctionnement_width - margin.left - margin.right

        if (legends_width + d3.select(this).node().getBBox().width > w) {
          legends_width = legends_pie_width_start
          legends_height += 20
        }
        return translate.replace('%x%', 10+legends_width).replace('%y%', legends_height)
      })
    })

</script>
